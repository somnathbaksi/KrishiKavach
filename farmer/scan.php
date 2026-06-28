<?php
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/upload.php';
$user = require_login();
$uploadError = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $product = trim($_POST['product_name'] ?? 'New Product');
        $type = $_POST['product_type'] ?? 'Pesticide';
        $batch = trim($_POST['batch_no'] ?? 'BATCH-001');
        $seller = trim($_POST['seller_name'] ?? 'Local Dealer');
        $risk = $_POST['risk_level'] ?? 'Medium';
        $lat = ($_POST['latitude'] ?? '') !== '' ? (float) $_POST['latitude'] : null;
        $lng = ($_POST['longitude'] ?? '') !== '' ? (float) $_POST['longitude'] : null;
        $accuracy = ($_POST['location_accuracy'] ?? '') !== '' ? (float) $_POST['location_accuracy'] : null;
        $confidence = $risk === 'High' ? 42 : ($risk === 'Medium' ? 68 : 89);
        $summary = $risk === 'High'
            ? 'QR code failed, batch sequence is unusual, and package layout needs officer review.'
            : 'Initial package checks completed. Save evidence before final report.';

        db()->beginTransaction();

        $caseNo = 'KK-' . date('Y') . '-' . str_pad((string) random_int(20, 999), 3, '0', STR_PAD_LEFT);
        $stmt = db()->prepare('INSERT INTO cases (user_id, case_no, product_name, product_type, batch_no, seller_name, risk_level, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user['id'], $caseNo, $product, $type, $batch, $seller, $risk, $risk === 'High' ? 'Ready' : 'Evidence Pending']);
        $caseId = (int) db()->lastInsertId();

        $stmt = db()->prepare('INSERT INTO product_scans (user_id, case_id, product_name, product_type, batch_no, seller_name, confidence, risk_level, ai_summary, latitude, longitude, location_accuracy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user['id'], $caseId, $product, $type, $batch, $seller, $confidence, $risk, $summary, $lat, $lng, $accuracy]);
        $scanId = (int) db()->lastInsertId();

        $fileMap = [
            'product_front' => ['Product Photo', 'front-label'],
            'product_back' => ['Product Photo', 'back-label'],
            'qr_photo' => ['QR Photo', 'qr-closeup'],
            'purchase_bill' => ['Purchase Bill', 'purchase-bill'],
        ];

        foreach ($fileMap as $input => [$evidenceType, $prefix]) {
            $uploaded = upload_evidence_file($_FILES[$input] ?? [], $prefix);
            if (!$uploaded) {
                continue;
            }
            $quality = $input === 'qr_photo' && $risk === 'High' ? 'Retake' : 'Clear';
            $stmt = db()->prepare('INSERT INTO evidence_files (user_id, case_id, file_name, file_path, original_name, evidence_type, quality_status, notes, latitude, longitude, location_accuracy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $user['id'],
                $caseId,
                $uploaded['file_name'],
                $uploaded['file_path'],
                $uploaded['original_name'],
                $evidenceType,
                $quality,
                $prefix . ' uploaded during product scan.',
                $lat,
                $lng,
                $accuracy,
            ]);
        }

        $eventStmt = db()->prepare('INSERT INTO case_events (case_id, icon, title, description, event_status, event_date) VALUES (?, ?, ?, ?, ?, NOW())');
        $eventStmt->execute([$caseId, 'scan-line', 'Product scan completed', $summary, status_class($risk)]);
        $eventStmt->execute([$caseId, 'map-pin', 'Location captured', $lat !== null && $lng !== null ? "Geo location saved: {$lat}, {$lng}" : 'Location permission was not available.', $lat !== null ? 'ok' : 'warn']);
        $eventStmt->execute([$caseId, 'folder-lock', 'Scan evidence uploaded', 'Product photos and bill files were saved in evidence locker.', 'ok']);

        $stmt = db()->prepare('INSERT INTO reports (user_id, case_id, report_no, complaint_summary, readiness, status) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user['id'], $caseId, 'RPT-' . substr($caseNo, 3), $summary, $risk === 'High' ? 76 : 58, 'Draft']);

        $stmt = db()->prepare('INSERT INTO notifications (user_id, case_id, title, message, severity, is_read) VALUES (?, ?, ?, ?, ?, 0)');
        $stmt->execute([$user['id'], $caseId, $risk === 'High' ? 'High-risk scan created' : 'Scan saved', $summary, status_class($risk)]);

        db()->commit();
        redirect('farmer/scan-detail.php?id=' . $scanId);
    } catch (Throwable $e) {
        if (db()->inTransaction()) {
            db()->rollBack();
        }
        $uploadError = $e->getMessage();
    }
}
$title = 'Product Scan | Krishi Kavach AI';
$pageTitle = 'Product Scan';
$pageSubtitle = text_hi('पैकेट, QR, बैच, बिल', 'Packet, QR, batch, bill');
$activeTab = 'scan';
$back = url('farmer/dashboard.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="upload">
  <div><div class="status-icon"><i data-lucide="image-up"></i></div><h2><?= e(text_hi('पैकेट फोटो अपलोड करें', 'Upload packet photos')) ?></h2><p><?= e(text_hi('फ्रंट, बैक, QR कोड, एक्सपायरी, MRP, बैच नंबर और बिल कैप्चर करें।', 'Capture front, back, QR code, expiry, MRP, batch number, and bill.')) ?></p><button class="btn btn-primary" type="button" data-upload-demo><i data-lucide="plus"></i><?= e(text_hi('फोटो जोड़ें', 'Add Photos')) ?></button></div>
</section>
<section class="metric-grid">
  <div class="metric"><i data-lucide="package"></i><div><strong><?= e(text_hi('फ्रंट', 'Front')) ?></strong><span data-front-status><?= e(text_hi('प्रतीक्षा', 'Waiting')) ?></span></div></div>
  <div class="metric"><i data-lucide="qr-code"></i><div><strong>QR</strong><span data-qr-status><?= e(text_hi('प्रतीक्षा', 'Waiting')) ?></span></div></div>
  <div class="metric"><i data-lucide="receipt-text"></i><div><strong><?= e(text_hi('बिल', 'Bill')) ?></strong><span data-bill-status><?= e(text_hi('प्रतीक्षा', 'Waiting')) ?></span></div></div>
  <div class="metric"><i data-lucide="badge-check"></i><div><strong>72%</strong><span><?= e(label_text('Ready')) ?></span></div></div>
</section>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('उत्पाद विवरण', 'Product Details')) ?></h2><span class="badge"><?= e(label_text('Draft')) ?></span></div>
  <?php if ($uploadError): ?><div class="badge red"><?= e($uploadError) ?></div><?php endif; ?>
  <form class="form" method="post" enctype="multipart/form-data">
    <div class="field"><label><?= e(text_hi('उत्पाद प्रकार', 'Product Type')) ?></label><select name="product_type"><option value="Seeds"><?= e(label_text('Seeds')) ?></option><option value="Fertilizer"><?= e(label_text('Fertilizer')) ?></option><option value="Pesticide" selected><?= e(label_text('Pesticide')) ?></option></select></div>
    <div class="field"><label><?= e(text_hi('ब्रांड / उत्पाद', 'Brand / Product')) ?></label><input name="product_name" value="CropSafe Insecticide"></div>
    <div class="field"><label><?= e(text_hi('बैच नंबर', 'Batch Number')) ?></label><input name="batch_no" value="CS-9X-2048"></div>
    <div class="field"><label><?= e(text_hi('विक्रेता', 'Seller')) ?></label><input name="seller_name" value="Mahalaxmi Krishi Seva Kendra"></div>
    <div class="field"><label><?= e(text_hi('जोखिम स्तर', 'Risk Level')) ?></label><select name="risk_level"><option value="Low"><?= e(label_text('Low')) ?></option><option value="Medium"><?= e(label_text('Medium')) ?></option><option value="High" selected><?= e(label_text('High')) ?></option></select></div>
    <div class="field"><label><?= e(text_hi('फ्रंट फोटो', 'Front Photo')) ?></label><input name="product_front" type="file" accept="image/*"></div>
    <div class="field"><label><?= e(text_hi('बैक फोटो', 'Back Photo')) ?></label><input name="product_back" type="file" accept="image/*"></div>
    <div class="field"><label><?= e(text_hi('QR फोटो', 'QR Photo')) ?></label><input name="qr_photo" type="file" accept="image/*"></div>
    <div class="field"><label><?= e(text_hi('खरीद बिल', 'Purchase Bill')) ?></label><input name="purchase_bill" type="file" accept="image/*,.pdf"></div>
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
    <input type="hidden" name="location_accuracy" id="location_accuracy">
    <div class="list-row"><div class="status-icon warn"><i data-lucide="map-pin"></i></div><div><strong><?= e(text_hi('जियो टैग', 'Geo tag')) ?></strong><span id="geoStatus"><?= e(text_hi('लोकेशन अनुमति का इंतजार है।', 'Waiting for location permission.')) ?></span></div></div>
    <button class="btn btn-primary" type="submit"><i data-lucide="sparkles"></i><?= e(text_hi('AI जांच चलाएं', 'Run AI Check')) ?></button>
  </form>
</section>
<section class="card">
  <a class="list-row" href="<?= url('farmer/product-database.php') ?>"><div class="status-icon ok"><i data-lucide="database"></i></div><div><strong><?= e(text_hi('उत्पाद डेटाबेस जांचें', 'Check product database')) ?></strong><span><?= e(text_hi('ज्ञात लेबल पैटर्न और संदिग्ध बैच अलर्ट की तुलना करें।', 'Compare known label patterns and suspicious batch alerts.')) ?></span></div><i data-lucide="chevron-right"></i></a>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
