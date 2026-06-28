<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$case = fetch_one('SELECT * FROM cases WHERE user_id = ? ORDER BY id DESC LIMIT 1', [$user['id']]);
$events = fetch_all('SELECT * FROM case_events WHERE case_id = ? ORDER BY event_date', [$case['id'] ?? 0]);
$title = 'Case Timeline | Krishi Kavach AI';
$pageTitle = 'Case Timeline';
$pageSubtitle = $case['case_no'] ?? 'Case';
$activeTab = 'report';
$back = url('farmer/case-detail.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card">
  <div class="card-head"><h2><?= e($case['product_name']) ?></h2><span class="badge <?= badge_class($case['risk_level']) ?>"><?= e(label_text($case['risk_level'])) ?> <?= e(text_hi('जोखिम', 'risk')) ?></span></div>
  <div class="risk <?= $case['risk_level'] === 'High' ? 'high' : '' ?>"><div class="status-icon <?= status_class($case['risk_level']) ?>"><i data-lucide="triangle-alert"></i></div><div><h2><?= e(text_hi('शिकायत सबूत समयरेखा', 'Complaint evidence timeline')) ?></h2><p><?= e(text_hi('खरीद, AI स्कैन, फसल नुकसान और अधिकारी सबमिशन की क्रमवार जानकारी।', 'Chronological proof trail for product purchase, AI scan, crop damage, and officer submission.')) ?></p></div></div>
</section>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('समयरेखा विवरण', 'Timeline Details')) ?></h2><span class="badge green"><?= count($events) ?> <?= e(text_hi('घटनाएं', 'events')) ?></span></div>
  <div class="list">
    <?php foreach ($events as $event): ?>
      <div class="list-row"><div class="status-icon <?= e($event['event_status']) ?>"><i data-lucide="<?= e($event['icon']) ?>"></i></div><div><strong><?= e($event['title']) ?></strong><span><?= date('d M Y, h:i A', strtotime($event['event_date'])) ?>. <?= e($event['description']) ?></span></div></div>
    <?php endforeach; ?>
  </div>
</section>
<section class="card"><div class="actions"><a class="btn btn-outline" href="<?= url('farmer/upload-evidence.php') ?>"><i data-lucide="upload"></i><?= e(text_hi('सबूत जोड़ें', 'Add Proof')) ?></a><a class="btn btn-primary" href="<?= url('farmer/report-preview.php') ?>"><i data-lucide="file-warning"></i><?= e(text_hi('रिपोर्ट खोलें', 'Open Report')) ?></a></div></section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
