<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
$id = (int) ($_GET['id'] ?? 0);
$report = fetch_one('SELECT r.*, c.case_no, c.product_name, c.batch_no, c.seller_name, u.name farmer_name, u.mobile FROM reports r JOIN cases c ON c.id = r.case_id JOIN users u ON u.id = r.user_id WHERE r.id = ?', [$id]);
$title = 'Report Detail | Krishi Kavach AI';
$pageTitle = text_hi('रिपोर्ट विवरण', 'Report Detail');
$pageSubtitle = $report['report_no'] ?? '';
$activeTab = 'reports';
$back = url('admin/reports.php');
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card">
  <div class="card-head"><h2><?= e($report['report_no']) ?></h2><span class="badge <?= badge_class($report['status']) ?>"><?= e(label_text($report['status'])) ?></span></div>
  <p class="muted" style="line-height:1.6;"><strong><?= e(text_hi('किसान', 'Farmer')) ?>:</strong> <?= e($report['farmer_name']) ?>, <?= e($report['mobile']) ?></p>
  <p class="muted" style="line-height:1.6;"><strong><?= e(text_hi('उत्पाद', 'Product')) ?>:</strong> <?= e($report['product_name']) ?>, <?= e($report['batch_no']) ?>, <?= e($report['seller_name']) ?></p>
  <p class="muted" style="line-height:1.6;"><?= e($report['complaint_summary']) ?></p>
</section>
<section class="card"><div class="actions"><a class="btn btn-outline" href="<?= url('admin/case-detail.php?id=' . (int) $report['case_id']) ?>"><?= e(text_hi('केस खोलें', 'Open Case')) ?></a><button class="btn btn-primary" type="button"><?= e(text_hi('स्वीकृत', 'Approve')) ?></button></div></section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
