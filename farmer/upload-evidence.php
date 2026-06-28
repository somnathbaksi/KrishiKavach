<?php
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/upload.php';
$user = require_login();
$case = fetch_one('SELECT * FROM cases WHERE user_id = ? ORDER BY id DESC LIMIT 1', [$user['id']]);
$uploadError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $case) {
    try {
        $lat = ($_POST['latitude'] ?? '') !== '' ? (float) $_POST['latitude'] : null;
        $lng = ($_POST['longitude'] ?? '') !== '' ? (float) $_POST['longitude'] : null;
        $accuracy = ($_POST['location_accuracy'] ?? '') !== '' ? (float) $_POST['location_accuracy'] : null;
        $uploaded = upload_evidence_file($_FILES['evidence_file'] ?? [], 'locker-evidence');
        $fileName = $uploaded['file_name'] ?? trim($_POST['file_name'] ?? 'manual-evidence.txt');
        $filePath = $uploaded['file_path'] ?? null;
        $originalName = $uploaded['original_name'] ?? $fileName;

        $stmt = db()->prepare('INSERT INTO evidence_files (user_id, case_id, file_name, file_path, original_name, evidence_type, quality_status, notes, latitude, longitude, location_accuracy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user['id'], $case['id'], $fileName, $filePath, $originalName, $_POST['evidence_type'] ?? 'Product Photo', $_POST['quality_status'] ?? 'Clear', trim($_POST['notes'] ?? ''), $lat, $lng, $accuracy]);

        db()->prepare('INSERT INTO case_events (case_id, icon, title, description, event_status, event_date) VALUES (?, "folder-lock", "Evidence uploaded", "New evidence file added to locker.", "ok", NOW())')->execute([$case['id']]);
        redirect('farmer/locker.php');
    } catch (Throwable $e) {
        $uploadError = $e->getMessage();
    }
}

$title = 'Upload Evidence | Krishi Kavach AI';
$pageTitle = 'Upload Evidence';
$pageSubtitle = text_hi('केस में सबूत जोड़ें', 'Attach to case');
$activeTab = 'locker';
$back = url('farmer/locker.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="upload">
  <div><div class="status-icon"><i data-lucide="cloud-upload"></i></div><h2><?= e(text_hi('फाइल जोड़ें', 'Add file')) ?></h2><p><?= e(text_hi('फोटो, बिल, PDF या नोट अपलोड करें।', 'Upload photo, bill, PDF, or note.')) ?></p></div>
</section>
<section class="card">
  <?php if ($uploadError): ?><div class="badge red"><?= e($uploadError) ?></div><?php endif; ?>
  <form class="form" method="post" enctype="multipart/form-data">
    <div class="field"><label><?= e(text_hi('फाइल', 'File')) ?></label><input name="evidence_file" type="file" accept="image/*,.pdf,.txt"></div>
    <div class="field"><label><?= e(text_hi('फाइल नाम', 'File Name')) ?></label><input name="file_name" value="manual-evidence.txt"></div>
    <div class="field"><label><?= e(text_hi('सबूत प्रकार', 'Evidence Type')) ?></label><select name="evidence_type"><option value="Purchase Bill"><?= e(label_text('Purchase Bill')) ?></option><option value="Product Photo"><?= e(label_text('Product Photo')) ?></option><option value="QR Photo"><?= e(label_text('QR Photo')) ?></option><option value="Crop Damage"><?= e(label_text('Crop Damage')) ?></option><option value="Dealer Note"><?= e(label_text('Dealer Note')) ?></option></select></div>
    <div class="field"><label><?= e(text_hi('गुणवत्ता', 'Quality')) ?></label><select name="quality_status"><option value="Clear"><?= e(label_text('Clear')) ?></option><option value="Retake"><?= e(label_text('Retake')) ?></option><option value="Draft"><?= e(label_text('Draft')) ?></option></select></div>
    <div class="field"><label><?= e(text_hi('नोट', 'Note')) ?></label><textarea name="notes" placeholder="<?= e(text_hi('स्थान, तारीख या निरीक्षण जोड़ें', 'Add location, date, or observation')) ?>"></textarea></div>
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
    <input type="hidden" name="location_accuracy" id="location_accuracy">
    <div class="list-row"><div class="status-icon warn"><i data-lucide="map-pin"></i></div><div><strong><?= e(text_hi('जियो टैग', 'Geo tag')) ?></strong><span id="geoStatus"><?= e(text_hi('लोकेशन अनुमति का इंतजार है।', 'Waiting for location permission.')) ?></span></div></div>
    <button class="btn btn-primary" type="submit"><?= e(text_hi('सबूत सेव करें', 'Save Evidence')) ?></button>
  </form>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
