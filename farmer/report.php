<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$report = fetch_one('SELECT r.*, c.case_no, c.product_name FROM reports r JOIN cases c ON c.id = r.case_id WHERE r.user_id = ? ORDER BY r.id DESC LIMIT 1', [$user['id']]);
$summary = fetch_all('SELECT evidence_type, COUNT(*) c, SUM(quality_status = "Retake") retakes FROM evidence_files WHERE user_id = ? GROUP BY evidence_type', [$user['id']]);
$title = 'Complaint Report | Krishi Kavach AI';
$pageTitle = 'Report';
$pageSubtitle = text_hi('शिकायत के लिए तैयार फाइल', 'Complaint-ready file');
$activeTab = 'report';
$back = url('farmer/dashboard.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('रिपोर्ट बिल्डर', 'Report Builder')) ?></h2><span class="badge yellow"><?= e(label_text($report['status'] ?? 'Draft')) ?></span></div>
  <form class="form">
    <div class="field"><label><?= e(text_hi('रिपोर्ट नंबर', 'Report Number')) ?></label><input value="<?= e($report['report_no'] ?? '') ?>" readonly></div>
    <div class="field"><label><?= e(text_hi('केस', 'Case')) ?></label><input value="<?= e(($report['case_no'] ?? '') . ' - ' . ($report['product_name'] ?? '')) ?>" readonly></div>
    <div class="field"><label><?= e(text_hi('शिकायत सारांश', 'Complaint Summary')) ?></label><textarea readonly><?= e($report['complaint_summary'] ?? '') ?></textarea></div>
    <a class="btn btn-primary" href="<?= url('farmer/report-preview.php') ?>"><i data-lucide="file-down"></i><?= e(text_hi('रिपोर्ट देखें', 'Preview Report')) ?></a>
  </form>
</section>
<section class="card">
  <div class="actions"><a class="btn btn-outline" href="<?= url('farmer/case-detail.php') ?>"><i data-lucide="folder-open"></i><?= e(label_text('Case Detail')) ?></a><a class="btn btn-primary" href="<?= url('farmer/submitted-success.php') ?>"><i data-lucide="send"></i><?= e(text_hi('जमा करें', 'Submit')) ?></a></div>
</section>
<section class="card">
  <div class="card-head"><h2><?= e(label_text('Evidence Attached')) ?></h2><span class="badge green"><?= (int) ($report['readiness'] ?? 0) ?>%</span></div>
  <div class="list">
    <?php foreach ($summary as $row): ?>
      <a class="list-row" href="<?= url('farmer/evidence-attached.php') ?>"><div class="status-icon <?= ((int) $row['retakes'] > 0) ? 'warn' : 'ok' ?>"><i data-lucide="folder-lock"></i></div><div><strong><?= e(label_text($row['evidence_type'])) ?></strong><span><?= (int) $row['c'] ?> <?= e(text_hi('फाइल जुड़ी हैं।', 'file(s) attached.')) ?></span></div><span class="badge <?= ((int) $row['retakes'] > 0) ? 'yellow' : 'green' ?>"><?= ((int) $row['retakes'] > 0) ? e(label_text('Retake')) : e(label_text('Clear')) ?></span></a>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
