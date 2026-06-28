<?php
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/upload.php';
$admin = require_admin();
$files = fetch_all('SELECT ef.*, c.case_no, u.name farmer_name FROM evidence_files ef JOIN cases c ON c.id = ef.case_id JOIN users u ON u.id = ef.user_id ORDER BY ef.uploaded_at DESC');
$title = 'Evidence | Krishi Kavach AI';
$pageTitle = text_hi('सबूत', 'Evidence');
$pageSubtitle = text_hi('अपलोडेड फाइलें', 'Uploaded files');
$activeTab = 'more';
$back = url('admin/more.php');
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card"><div class="list">
<?php foreach ($files as $file): ?>
  <div class="list-row">
    <div class="status-icon <?= status_class($file['quality_status']) ?>"><i data-lucide="folder-lock"></i></div>
    <div>
      <strong><?= e($file['original_name'] ?: $file['file_name']) ?></strong>
      <span><?= e($file['case_no']) ?> · <?= e($file['farmer_name']) ?> · <?= e(label_text($file['evidence_type'])) ?></span>
      <?php if (evidence_is_image($file['file_path'])): ?>
        <img src="<?= url($file['file_path']) ?>" alt="<?= e($file['evidence_type']) ?>" style="width:100%;max-height:170px;object-fit:cover;border-radius:14px;margin-top:10px;">
      <?php elseif (!empty($file['file_path'])): ?>
        <a class="badge" href="<?= url($file['file_path']) ?>" target="_blank"><?= e(text_hi('फाइल देखें', 'View file')) ?></a>
      <?php endif; ?>
      <?php if ($file['latitude'] && $file['longitude']): ?>
        <span><?= e(text_hi('जियो टैग:', 'Geo tag:')) ?> <?= e($file['latitude']) ?>, <?= e($file['longitude']) ?></span>
      <?php endif; ?>
    </div>
    <span class="badge <?= badge_class($file['quality_status']) ?>"><?= e(label_text($file['quality_status'])) ?></span>
  </div>
<?php endforeach; ?>
</div></section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
