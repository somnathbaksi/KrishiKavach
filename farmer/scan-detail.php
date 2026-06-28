<?php
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/upload.php';
$user = require_login();
$id = (int) ($_GET['id'] ?? 0);
$scan = fetch_one('SELECT * FROM product_scans WHERE id = ? AND user_id = ?', [$id, $user['id']])
    ?? fetch_one('SELECT * FROM product_scans WHERE user_id = ? ORDER BY id DESC LIMIT 1', [$user['id']]);
$files = fetch_all('SELECT * FROM evidence_files WHERE case_id = ? ORDER BY uploaded_at DESC', [$scan['case_id'] ?? 0]);
$title = 'Scan Detail | Krishi Kavach AI';
$pageTitle = 'Scan Detail';
$pageSubtitle = $scan['product_name'] ?? 'Product';
$activeTab = 'scan';
$back = url('farmer/scan-history.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card">
  <div class="risk <?= $scan['risk_level'] === 'High' ? 'high' : '' ?>">
    <div class="status-icon <?= status_class($scan['risk_level']) ?>"><i data-lucide="triangle-alert"></i></div>
    <div><h2><?= e($scan['risk_level']) ?> Risk Product</h2><p><?= e($scan['ai_summary']) ?></p></div>
  </div>
</section>
<section class="metric-grid">
  <div class="metric"><i data-lucide="badge-percent"></i><div><strong><?= (int) $scan['confidence'] ?>%</strong><span>Confidence</span></div></div>
  <div class="metric"><i data-lucide="barcode"></i><div><strong><?= e($scan['batch_no']) ?></strong><span>Batch</span></div></div>
  <div class="metric"><i data-lucide="map-pin"></i><div><strong><?= $scan['latitude'] ? e((string) $scan['latitude']) : '-' ?></strong><span><?= e(text_hi('अक्षांश', 'Latitude')) ?></span></div></div>
  <div class="metric"><i data-lucide="map"></i><div><strong><?= $scan['longitude'] ? e((string) $scan['longitude']) : '-' ?></strong><span><?= e(text_hi('देशांतर', 'Longitude')) ?></span></div></div>
</section>
<section class="card">
  <div class="card-head"><h2>Checks</h2><span class="badge <?= badge_class($scan['risk_level']) ?>"><?= e($scan['risk_level']) ?></span></div>
  <div class="list">
    <div class="list-row"><div class="status-icon <?= status_class($scan['risk_level']) ?>"><i data-lucide="qr-code"></i></div><div><strong>QR and batch review</strong><span><?= e($scan['ai_summary']) ?></span></div></div>
    <div class="list-row"><div class="status-icon ok"><i data-lucide="store"></i></div><div><strong>Seller captured</strong><span><?= e($scan['seller_name']) ?></span></div></div>
  </div>
  <div class="actions" style="margin-top: 12px;"><a class="btn btn-outline" href="<?= url('farmer/upload-evidence.php') ?>">Add Evidence</a><a class="btn btn-primary" href="<?= url('farmer/case-detail.php') ?>">Open Case</a></div>
</section>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('अपलोड फोटो', 'Uploaded Photos')) ?></h2><span class="badge green"><?= count($files) ?></span></div>
  <div class="list">
    <?php foreach ($files as $file): ?>
      <div class="list-row">
        <div class="status-icon <?= status_class($file['quality_status']) ?>"><i data-lucide="image"></i></div>
        <div>
          <strong><?= e(label_text($file['evidence_type'])) ?></strong>
          <span><?= e($file['original_name'] ?: $file['file_name']) ?> · <?= e(label_text($file['quality_status'])) ?></span>
          <?php if (evidence_is_image($file['file_path'])): ?>
            <img src="<?= url($file['file_path']) ?>" alt="<?= e($file['evidence_type']) ?>" style="width:100%;max-height:180px;object-fit:cover;border-radius:14px;margin-top:10px;">
          <?php else: ?>
            <a class="badge" href="<?= url($file['file_path'] ?? '') ?>" target="_blank"><?= e(text_hi('फाइल देखें', 'View file')) ?></a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
