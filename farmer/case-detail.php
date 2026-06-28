<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$case = fetch_one('SELECT * FROM cases WHERE user_id = ? ORDER BY id DESC LIMIT 1', [$user['id']]);
$events = fetch_all('SELECT * FROM case_events WHERE case_id = ? ORDER BY event_date', [$case['id'] ?? 0]);
$files = (int) fetch_one('SELECT COUNT(*) c FROM evidence_files WHERE case_id = ?', [$case['id'] ?? 0])['c'];
$title = 'Case Detail | Krishi Kavach AI';
$pageTitle = $case['case_no'] ?? 'Case Detail';
$pageSubtitle = $case['product_name'] ?? 'Product';
$activeTab = 'report';
$back = url('farmer/dashboard.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="metric-grid"><div class="metric"><i data-lucide="triangle-alert"></i><div><strong><?= e($case['risk_level']) ?></strong><span>Risk level</span></div></div><div class="metric"><i data-lucide="folder-lock"></i><div><strong><?= $files ?></strong><span>Files saved</span></div></div></section>
<section class="card">
  <div class="card-head"><h2>Case Timeline</h2><span class="badge green"><?= e($case['status']) ?></span></div>
  <div class="list">
    <?php foreach (array_slice($events, 0, 3) as $event): ?>
      <a class="list-row" href="<?= url('farmer/case-timeline.php') ?>"><div class="status-icon <?= e($event['event_status']) ?>"><i data-lucide="<?= e($event['icon']) ?>"></i></div><div><strong><?= e($event['title']) ?></strong><span><?= date('d M Y', strtotime($event['event_date'])) ?></span></div><i data-lucide="chevron-right"></i></a>
    <?php endforeach; ?>
  </div>
  <div class="actions" style="margin-top: 12px;"><a class="btn btn-outline" href="<?= url('farmer/upload-evidence.php') ?>">Add Proof</a><a class="btn btn-primary" href="<?= url('farmer/report-preview.php') ?>">Report</a></div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
