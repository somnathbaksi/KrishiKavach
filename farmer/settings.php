<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$title = 'Settings | Krishi Kavach AI';
$pageTitle = 'Settings';
$pageSubtitle = text_hi('ऐप प्राथमिकताएं', 'App preferences');
$activeTab = 'profile';
$back = url('farmer/profile.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card">
  <div class="list">
    <div class="list-row"><div class="status-icon ok"><i data-lucide="languages"></i></div><div><strong><?= e(text_hi('भाषा', 'Language')) ?></strong><span><?= e(text_hi('डिफॉल्ट हिन्दी, दूसरी भाषा English', 'Default Hindi, secondary English')) ?></span></div><a class="badge" href="<?= e(lang_url(current_lang() === 'hi' ? 'en' : 'hi')) ?>"><?= current_lang() === 'hi' ? 'English' : 'हिन्दी' ?></a></div>
    <a class="list-row" href="<?= url('farmer/notifications.php') ?>"><div class="status-icon warn"><i data-lucide="bell"></i></div><div><strong><?= e(label_text('Notifications')) ?></strong><span><?= e(text_hi('जोखिम अलर्ट और रिमाइंडर', 'Risk alerts and reminders')) ?></span></div><i data-lucide="chevron-right"></i></a>
    <div class="list-row"><div class="status-icon ok"><i data-lucide="shield"></i></div><div><strong><?= e(text_hi('गोपनीयता', 'Privacy')) ?></strong><span><?= e(text_hi('सबूत किसान केस से जुड़े हैं।', 'Evidence is linked to farmer cases.')) ?></span></div><span class="badge green"><?= e(text_hi('चालू', 'On')) ?></span></div>
    <div class="list-row"><div class="status-icon ok"><i data-lucide="info"></i></div><div><strong><?= e(text_hi('ऐप के बारे में', 'About App')) ?></strong><span>Krishi Kavach AI farmer panel v1.0</span></div></div>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
