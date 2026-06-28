<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
$id = (int) ($_GET['id'] ?? 0);
$farmer = fetch_one('SELECT u.*, fp.* FROM users u LEFT JOIN farmer_profiles fp ON fp.user_id = u.id WHERE u.id = ? AND u.role = "farmer"', [$id]);
$caseCount = (int) fetch_one('SELECT COUNT(*) c FROM cases WHERE user_id = ?', [$id])['c'];
$scanCount = (int) fetch_one('SELECT COUNT(*) c FROM product_scans WHERE user_id = ?', [$id])['c'];
$fileCount = (int) fetch_one('SELECT COUNT(*) c FROM evidence_files WHERE user_id = ?', [$id])['c'];
$title = 'Farmer Detail | Krishi Kavach AI';
$pageTitle = text_hi('किसान विवरण', 'Farmer Detail');
$pageSubtitle = $farmer['name'] ?? '';
$activeTab = 'farmers';
$back = url('admin/farmers.php');
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="profile-hero"><div class="avatar"><?= e(strtoupper(substr($farmer['name'] ?? 'F', 0, 1))) ?></div><div><h1 style="margin:0;"><?= e($farmer['name']) ?></h1><p style="margin:6px 0 0;color:#e7f2e5;"><?= e($farmer['village']) ?>, <?= e($farmer['district']) ?> · <?= e($farmer['primary_crop']) ?></p></div></section>
<section class="metric-grid"><div class="metric"><i data-lucide="folder-open"></i><div><strong><?= $caseCount ?></strong><span><?= e(text_hi('केस', 'Cases')) ?></span></div></div><div class="metric"><i data-lucide="scan-line"></i><div><strong><?= $scanCount ?></strong><span><?= e(text_hi('स्कैन', 'Scans')) ?></span></div></div><div class="metric"><i data-lucide="folder-lock"></i><div><strong><?= $fileCount ?></strong><span><?= e(text_hi('सबूत', 'Evidence')) ?></span></div></div><div class="metric"><i data-lucide="badge-check"></i><div><strong><?= e($farmer['kyc_status']) ?></strong><span>KYC</span></div></div></section>
<section class="card">
  <div class="list">
    <div class="list-row"><div class="status-icon ok"><i data-lucide="phone"></i></div><div><strong><?= e(text_hi('मोबाइल', 'Mobile')) ?></strong><span><?= e($farmer['mobile']) ?></span></div></div>
    <div class="list-row"><div class="status-icon ok"><i data-lucide="map-pin"></i></div><div><strong><?= e(text_hi('स्थान', 'Location')) ?></strong><span><?= e($farmer['taluka']) ?>, <?= e($farmer['district']) ?>, <?= e($farmer['state']) ?></span></div></div>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
