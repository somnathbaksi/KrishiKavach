<?php
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/upload.php';
$user = require_login();
$case = fetch_one('SELECT * FROM cases WHERE user_id = ? ORDER BY id DESC LIMIT 1', [$user['id']]);
$files = fetch_all('SELECT * FROM evidence_files WHERE user_id = ? AND case_id = ? ORDER BY uploaded_at DESC', [$user['id'], $case['id'] ?? 0]);
$title = 'Evidence Attached | Krishi Kavach AI';
$pageTitle = 'Evidence Attached';
$pageSubtitle = $case['case_no'] ?? 'Case';
$activeTab = 'report';
$back = url('farmer/report.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="metric-grid">
  <div class="metric"><i data-lucide="folder-lock"></i><div><strong><?= count($files) ?></strong><span><?= e(text_hi('कुल फाइलें', 'Total files')) ?></span></div></div>
  <div class="metric"><i data-lucide="badge-check"></i><div><strong>72%</strong><span><?= e(text_hi('रिपोर्ट तैयार', 'Report ready')) ?></span></div></div>
</section>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('जुड़ी हुई फाइलें', 'Attached Files')) ?></h2><span class="badge green"><?= count($files) ?> <?= e(text_hi('फाइलें', 'files')) ?></span></div>
  <div class="list">
    <?php foreach ($files as $file): ?>
      <div class="list-row">
        <div class="status-icon <?= status_class($file['quality_status']) ?>"><i data-lucide="<?= $file['evidence_type'] === 'Purchase Bill' ? 'receipt-text' : 'image' ?>"></i></div>
        <div>
          <strong><?= e($file['original_name'] ?: $file['file_name']) ?></strong>
          <span><?= e(label_text($file['evidence_type'])) ?> · <?= e(label_text($file['quality_status'])) ?></span>
          <?php if (evidence_is_image($file['file_path'])): ?>
            <img src="<?= url($file['file_path']) ?>" alt="<?= e($file['evidence_type']) ?>" style="width:100%;max-height:190px;object-fit:cover;border-radius:14px;margin-top:10px;">
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
  </div>
  <div class="actions" style="margin-top: 14px;"><a class="btn btn-outline" href="<?= url('farmer/upload-evidence.php') ?>"><i data-lucide="upload"></i><?= e(text_hi('और जोड़ें', 'Add More')) ?></a><a class="btn btn-primary" href="<?= url('farmer/report-preview.php') ?>"><i data-lucide="file-warning"></i><?= e(text_hi('रिपोर्ट देखें', 'Preview Report')) ?></a></div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
