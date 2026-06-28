<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$profile = fetch_one('SELECT * FROM farmer_profiles WHERE user_id = ?', [$user['id']]);
$metrics = [
    'scans' => (int) fetch_one('SELECT COUNT(*) c FROM product_scans WHERE user_id = ?', [$user['id']])['c'],
    'alerts' => (int) fetch_one('SELECT COUNT(*) c FROM product_scans WHERE user_id = ? AND risk_level IN ("High","Medium")', [$user['id']])['c'],
    'files' => (int) fetch_one('SELECT COUNT(*) c FROM evidence_files WHERE user_id = ?', [$user['id']])['c'],
    'ready' => (int) (fetch_one('SELECT readiness FROM reports WHERE user_id = ? ORDER BY id DESC LIMIT 1', [$user['id']])['readiness'] ?? 0),
];
$actions = fetch_all('SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 3', [$user['id']]);
$title = 'Dashboard | Krishi Kavach AI';
$pageTitle = 'Krishi Kavach AI';
$pageSubtitle = ($profile['village'] ?? 'Tasgaon') . ', ' . ($profile['district'] ?? 'Sangli');
$activeTab = 'home';
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="hero">
  <h1><?= e(text_hi('छिड़काव या बुवाई से पहले स्कैन करें।', 'Scan before you spray or sow.')) ?></h1>
  <p><?= e(text_hi('पैकेट जांचें, सबूत सुरक्षित रखें और शिकायत के लिए रिपोर्ट तैयार करें।', 'Check packaging, save proof, and prepare complaint-ready evidence.')) ?></p>
  <div class="actions"><a class="btn btn-yellow" href="<?= url('farmer/scan.php') ?>"><i data-lucide="camera"></i><?= e(label_text('Scan')) ?></a><a class="btn btn-ghost" href="<?= url('farmer/locker.php') ?>"><i data-lucide="upload"></i><?= e(text_hi('सबूत', 'Evidence')) ?></a></div>
</section>

<section class="metric-grid">
  <div class="metric"><i data-lucide="scan-line"></i><div><strong><?= $metrics['scans'] ?></strong><span><?= e(text_hi('कुल स्कैन', 'Total scans')) ?></span></div></div>
  <div class="metric"><i data-lucide="triangle-alert"></i><div><strong><?= $metrics['alerts'] ?></strong><span><?= e(text_hi('जोखिम अलर्ट', 'Risk alerts')) ?></span></div></div>
  <div class="metric"><i data-lucide="folder-lock"></i><div><strong><?= $metrics['files'] ?></strong><span><?= e(text_hi('लॉकर फाइलें', 'Locker files')) ?></span></div></div>
  <div class="metric"><i data-lucide="file-check-2"></i><div><strong><?= $metrics['ready'] ?>%</strong><span><?= e(text_hi('रिपोर्ट तैयार', 'Report ready')) ?></span></div></div>
</section>

<section class="card">
  <div class="card-head"><h2><?= e(text_hi('कार्य केंद्र', 'Action Center')) ?></h2><span class="badge yellow"><?= count($actions) ?> <?= e(text_hi('बाकी', 'pending')) ?></span></div>
  <div class="list">
    <?php foreach ($actions as $item): ?>
      <a class="list-row" href="<?= url('farmer/notification-detail.php?id=' . (int) $item['id']) ?>">
        <div class="status-icon <?= e($item['severity']) ?>"><i data-lucide="<?= $item['severity'] === 'bad' ? 'triangle-alert' : 'bell' ?>"></i></div>
        <div><strong><?= e($item['title']) ?></strong><span><?= e($item['message']) ?></span></div>
        <span class="badge <?= badge_class($item['severity']) ?>"><?= $item['is_read'] ? e(label_text('Read')) : e(label_text('New')) ?></span>
      </a>
    <?php endforeach; ?>
  </div>
  <div style="margin-top: 12px;"><a class="btn btn-outline" href="<?= url('farmer/scan-history.php') ?>"><i data-lucide="history"></i><?= e(text_hi('स्कैन इतिहास देखें', 'View Scan History')) ?></a></div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
