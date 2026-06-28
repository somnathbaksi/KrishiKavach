<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
$scans = fetch_all('SELECT ps.*, u.name farmer_name FROM product_scans ps JOIN users u ON u.id = ps.user_id ORDER BY ps.scanned_at DESC');
$title = 'Scans | Krishi Kavach AI';
$pageTitle = text_hi('स्कैन', 'Scans');
$pageSubtitle = text_hi('AI उत्पाद जांच', 'AI product checks');
$activeTab = 'more';
$back = url('admin/more.php');
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card"><div class="list">
<?php foreach ($scans as $scan): ?>
  <div class="list-row"><div class="status-icon <?= status_class($scan['risk_level']) ?>"><i data-lucide="scan-line"></i></div><div><strong><?= e($scan['product_name']) ?></strong><span><?= e($scan['farmer_name']) ?> · <?= (int) $scan['confidence'] ?>% · <?= e($scan['batch_no']) ?></span></div><span class="badge <?= badge_class($scan['risk_level']) ?>"><?= e(label_text($scan['risk_level'])) ?></span></div>
<?php endforeach; ?>
</div></section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
