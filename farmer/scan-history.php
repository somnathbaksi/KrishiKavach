<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$scans = fetch_all('SELECT * FROM product_scans WHERE user_id = ? ORDER BY scanned_at DESC', [$user['id']]);
$title = 'Scan History | Krishi Kavach AI';
$pageTitle = 'Scan History';
$pageSubtitle = 'All product checks';
$activeTab = 'scan';
$back = url('farmer/dashboard.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card">
  <div class="list">
    <?php foreach ($scans as $scan): ?>
      <a class="list-row" href="<?= url('farmer/scan-detail.php?id=' . (int) $scan['id']) ?>">
        <div class="status-icon <?= status_class($scan['risk_level']) ?>"><i data-lucide="<?= $scan['risk_level'] === 'High' ? 'triangle-alert' : 'scan-line' ?>"></i></div>
        <div><strong><?= e($scan['product_name']) ?></strong><span><?= e($scan['product_type']) ?>, <?= e($scan['batch_no']) ?></span></div>
        <span class="badge <?= badge_class($scan['risk_level']) ?>"><?= e($scan['risk_level']) ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
