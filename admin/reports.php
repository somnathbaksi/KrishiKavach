<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
$reports = fetch_all('SELECT r.*, c.case_no, c.product_name, u.name farmer_name FROM reports r JOIN cases c ON c.id = r.case_id JOIN users u ON u.id = r.user_id ORDER BY r.created_at DESC');
$title = 'Reports | Krishi Kavach AI';
$pageTitle = text_hi('रिपोर्ट', 'Reports');
$pageSubtitle = text_hi('शिकायत रिपोर्ट', 'Complaint reports');
$activeTab = 'reports';
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card"><div class="list">
<?php foreach ($reports as $report): ?>
  <a class="list-row" href="<?= url('admin/report-detail.php?id=' . (int) $report['id']) ?>"><div class="status-icon <?= status_class($report['status']) ?>"><i data-lucide="file-warning"></i></div><div><strong><?= e($report['report_no']) ?> · <?= e($report['product_name']) ?></strong><span><?= e($report['farmer_name']) ?> · <?= (int) $report['readiness'] ?>% <?= e(text_hi('तैयार', 'ready')) ?></span></div><span class="badge <?= badge_class($report['status']) ?>"><?= e(label_text($report['status'])) ?></span></a>
<?php endforeach; ?>
</div></section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
