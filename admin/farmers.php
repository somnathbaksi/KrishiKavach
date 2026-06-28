<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
$farmers = fetch_all('SELECT u.*, fp.village, fp.district, fp.primary_crop, fp.kyc_status FROM users u LEFT JOIN farmer_profiles fp ON fp.user_id = u.id WHERE u.role = "farmer" ORDER BY u.id DESC');
$title = 'Farmers | Krishi Kavach AI';
$pageTitle = text_hi('किसान', 'Farmers');
$pageSubtitle = text_hi('पंजीकृत किसान', 'Registered farmers');
$activeTab = 'farmers';
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('किसान सूची', 'Farmer List')) ?></h2><span class="badge green"><?= count($farmers) ?></span></div>
  <div class="list">
    <?php foreach ($farmers as $farmer): ?>
      <a class="list-row" href="<?= url('admin/farmer-detail.php?id=' . (int) $farmer['id']) ?>"><div class="status-icon ok"><i data-lucide="user-round"></i></div><div><strong><?= e($farmer['name']) ?></strong><span><?= e($farmer['village'] ?? '-') ?>, <?= e($farmer['district'] ?? '-') ?> · <?= e($farmer['primary_crop'] ?? '-') ?></span></div><span class="badge <?= $farmer['kyc_status'] === 'verified' ? 'green' : 'yellow' ?>"><?= e(text_hi($farmer['kyc_status'] === 'verified' ? 'सत्यापित' : 'बाकी', $farmer['kyc_status'] ?? 'pending')) ?></span></a>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
