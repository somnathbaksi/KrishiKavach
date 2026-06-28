<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
$title = 'Admin More | Krishi Kavach AI';
$pageTitle = text_hi('और विकल्प', 'More');
$pageSubtitle = text_hi('प्रशासन मेनू', 'Admin menu');
$activeTab = 'more';
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card"><div class="list">
  <a class="list-row" href="<?= url('admin/scans.php') ?>"><div class="status-icon ok"><i data-lucide="scan-line"></i></div><div><strong><?= e(text_hi('सभी स्कैन', 'All Scans')) ?></strong><span><?= e(text_hi('AI उत्पाद जांच देखें', 'View AI product checks')) ?></span></div><i data-lucide="chevron-right"></i></a>
  <a class="list-row" href="<?= url('admin/evidence.php') ?>"><div class="status-icon ok"><i data-lucide="folder-lock"></i></div><div><strong><?= e(text_hi('सबूत फाइलें', 'Evidence Files')) ?></strong><span><?= e(text_hi('अपलोडेड सबूत देखें', 'View uploaded evidence')) ?></span></div><i data-lucide="chevron-right"></i></a>
  <a class="list-row" href="<?= url('admin/notifications.php') ?>"><div class="status-icon warn"><i data-lucide="bell"></i></div><div><strong><?= e(text_hi('सूचनाएं', 'Notifications')) ?></strong><span><?= e(text_hi('सभी किसान अलर्ट', 'All farmer alerts')) ?></span></div><i data-lucide="chevron-right"></i></a>
  <a class="list-row" href="<?= url('admin/officers.php') ?>"><div class="status-icon ok"><i data-lucide="building-2"></i></div><div><strong><?= e(text_hi('अधिकारी निर्देशिका', 'Officer Directory')) ?></strong><span><?= e(text_hi('सहायता संपर्क प्रबंधित करें', 'Manage support contacts')) ?></span></div><i data-lucide="chevron-right"></i></a>
  <a class="list-row" href="<?= url('admin/settings.php') ?>"><div class="status-icon ok"><i data-lucide="settings"></i></div><div><strong><?= e(text_hi('सेटिंग्स', 'Settings')) ?></strong><span><?= e(text_hi('भाषा और सिस्टम', 'Language and system')) ?></span></div><i data-lucide="chevron-right"></i></a>
</div></section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
