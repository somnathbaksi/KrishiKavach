<?php
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/upload.php';
$admin = require_admin();
$id = (int) ($_GET['id'] ?? 0);
$case = fetch_one('SELECT c.*, u.name farmer_name, u.mobile FROM cases c JOIN users u ON u.id = c.user_id WHERE c.id = ?', [$id]);
$events = fetch_all('SELECT * FROM case_events WHERE case_id = ? ORDER BY event_date', [$id]);
$files = fetch_all('SELECT * FROM evidence_files WHERE case_id = ? ORDER BY uploaded_at DESC', [$id]);
$title = 'Case Detail | Krishi Kavach AI';
$pageTitle = text_hi('केस विवरण', 'Case Detail');
$pageSubtitle = $case['case_no'] ?? '';
$activeTab = 'cases';
$back = url('admin/cases.php');
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card">
  <div class="risk <?= ($case['risk_level'] ?? '') === 'High' ? 'high' : '' ?>"><div class="status-icon <?= status_class($case['risk_level'] ?? '') ?>"><i data-lucide="triangle-alert"></i></div><div><h2><?= e($case['product_name']) ?></h2><p><?= e($case['farmer_name']) ?> · <?= e($case['seller_name']) ?> · <?= e($case['batch_no']) ?></p></div></div>
</section>
<section class="metric-grid"><div class="metric"><i data-lucide="triangle-alert"></i><div><strong><?= e(label_text($case['risk_level'])) ?></strong><span><?= e(text_hi('जोखिम', 'Risk')) ?></span></div></div><div class="metric"><i data-lucide="folder-lock"></i><div><strong><?= count($files) ?></strong><span><?= e(text_hi('सबूत', 'Evidence')) ?></span></div></div></section>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('समयरेखा', 'Timeline')) ?></h2><span class="badge"><?= count($events) ?></span></div>
  <div class="list">
    <?php foreach ($events as $event): ?>
      <div class="list-row"><div class="status-icon <?= e($event['event_status']) ?>"><i data-lucide="<?= e($event['icon']) ?>"></i></div><div><strong><?= e($event['title']) ?></strong><span><?= e($event['description']) ?></span></div><span class="badge"><?= date('d M', strtotime($event['event_date'])) ?></span></div>
    <?php endforeach; ?>
  </div>
</section>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('सबूत फाइलें', 'Evidence Files')) ?></h2><span class="badge green"><?= count($files) ?></span></div>
  <div class="list">
    <?php foreach ($files as $file): ?>
      <div class="list-row">
        <div class="status-icon <?= status_class($file['quality_status']) ?>"><i data-lucide="image"></i></div>
        <div>
          <strong><?= e($file['original_name'] ?: $file['file_name']) ?></strong>
          <span><?= e(label_text($file['evidence_type'])) ?> · <?= e(label_text($file['quality_status'])) ?></span>
          <?php if (evidence_is_image($file['file_path'])): ?>
            <img src="<?= url($file['file_path']) ?>" alt="<?= e($file['evidence_type']) ?>" style="width:100%;max-height:180px;object-fit:cover;border-radius:14px;margin-top:10px;">
          <?php elseif (!empty($file['file_path'])): ?>
            <a class="badge" href="<?= url($file['file_path']) ?>" target="_blank"><?= e(text_hi('फाइल देखें', 'View file')) ?></a>
          <?php endif; ?>
          <?php if ($file['latitude'] && $file['longitude']): ?>
            <span><?= e(text_hi('जियो टैग:', 'Geo tag:')) ?> <?= e($file['latitude']) ?>, <?= e($file['longitude']) ?></span>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
