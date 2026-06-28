<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$report = fetch_one('SELECT r.*, c.case_no, c.product_name, c.batch_no, c.seller_name FROM reports r JOIN cases c ON c.id = r.case_id WHERE r.user_id = ? ORDER BY r.id DESC LIMIT 1', [$user['id']]);
$profile = fetch_one('SELECT * FROM farmer_profiles WHERE user_id = ?', [$user['id']]);
$title = 'Report Preview | Krishi Kavach AI';
$pageTitle = 'Report Preview';
$pageSubtitle = 'Complaint draft';
$activeTab = 'report';
$back = url('farmer/report.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card">
  <div class="card-head"><h2>Krishi Kavach Evidence Report</h2><span class="badge"><?= e($report['case_no'] ?? '') ?></span></div>
  <p class="muted" style="line-height: 1.6;"><strong>Farmer:</strong> <?= e($user['name']) ?>, <?= e($profile['village'] ?? '') ?>, <?= e($profile['district'] ?? '') ?></p>
  <p class="muted" style="line-height: 1.6;"><strong>Product:</strong> <?= e($report['product_name'] ?? '') ?>, batch <?= e($report['batch_no'] ?? '') ?>, seller <?= e($report['seller_name'] ?? '') ?>.</p>
  <p class="muted" style="line-height: 1.6;"><?= e($report['complaint_summary'] ?? '') ?></p>
</section>
<section class="card"><div class="actions"><button class="btn btn-outline" type="button"><i data-lucide="file-down"></i>Download</button><a class="btn btn-primary" href="<?= url('farmer/submitted-success.php') ?>"><i data-lucide="send"></i>Submit</a></div></section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
