<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$case = fetch_one('SELECT * FROM cases WHERE user_id = ? ORDER BY id DESC LIMIT 1', [$user['id']]);
$counts = fetch_all('SELECT evidence_type, COUNT(*) c FROM evidence_files WHERE user_id = ? GROUP BY evidence_type', [$user['id']]);
$events = fetch_all('SELECT * FROM case_events WHERE case_id = ? ORDER BY event_date DESC LIMIT 3', [$case['id'] ?? 0]);
$title = 'Evidence Locker | Krishi Kavach AI';
$pageTitle = 'Evidence Locker';
$pageSubtitle = text_hi('बिल, फोटो, रिपोर्ट', 'Bills, photos, reports');
$activeTab = 'locker';
$back = url('farmer/dashboard.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="metric-grid">
  <?php foreach (array_slice($counts, 0, 4) as $row): ?>
    <div class="metric"><i data-lucide="folder-lock"></i><div><strong><?= (int) $row['c'] ?></strong><span><?= e(label_text($row['evidence_type'])) ?></span></div></div>
  <?php endforeach; ?>
</section>
<section class="upload">
  <div><div class="status-icon"><i data-lucide="folder-plus"></i></div><h2><?= e(text_hi('नया सबूत जोड़ें', 'Add new evidence')) ?></h2><p><?= e(text_hi('बिल, पैकेट फोटो, फसल नुकसान फोटो, वीडियो या अधिकारी नोट जोड़ें।', 'Attach bill, packet photo, crop loss photo, video, or officer note.')) ?></p><a class="btn btn-primary" href="<?= url('farmer/upload-evidence.php') ?>"><i data-lucide="upload"></i><?= e(text_hi('फाइल चुनें', 'Choose Files')) ?></a></div>
</section>
<section class="card">
  <div class="card-head"><h2><?= e(label_text('Case Timeline')) ?></h2><span class="badge"><?= e($case['case_no'] ?? text_hi('कोई केस नहीं', 'No case')) ?></span></div>
  <div class="list">
    <?php foreach ($events as $event): ?>
      <a class="list-row" href="<?= url('farmer/case-timeline.php') ?>"><div class="status-icon <?= e($event['event_status']) ?>"><i data-lucide="<?= e($event['icon']) ?>"></i></div><div><strong><?= e($event['title']) ?></strong><span><?= e($event['description']) ?></span></div><span class="badge"><?= date('d M', strtotime($event['event_date'])) ?></span></a>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
