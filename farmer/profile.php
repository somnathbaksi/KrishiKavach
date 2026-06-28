<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$profile = fetch_one('SELECT * FROM farmer_profiles WHERE user_id = ?', [$user['id']]);
$title = 'Profile | Krishi Kavach AI';
$pageTitle = 'Profile';
$pageSubtitle = text_hi('किसान विवरण', 'Farmer details');
$activeTab = 'profile';
$back = url('farmer/dashboard.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="profile-hero"><div class="avatar"><?= e(strtoupper(substr($user['name'], 0, 1))) ?>P</div><div><h1 style="margin: 0;"><?= e($user['name']) ?></h1><p style="margin: 6px 0 0; color: #e7f2e5;"><?= e($profile['primary_crop']) ?> <?= e(text_hi('किसान', 'farmer')) ?>, <?= e($profile['village']) ?>, <?= e($profile['district']) ?></p></div></section>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('किसान विवरण', 'Farmer Details')) ?></h2><span class="badge green"><?= e(text_hi('सत्यापित', $profile['kyc_status'])) ?></span></div>
  <form class="form">
    <div class="field"><label><?= e(text_hi('नाम', 'Name')) ?></label><input value="<?= e($user['name']) ?>" readonly></div>
    <div class="field"><label><?= e(text_hi('मोबाइल', 'Mobile')) ?></label><input value="<?= e($user['mobile']) ?>" readonly></div>
    <div class="field"><label><?= e(text_hi('गांव', 'Village')) ?></label><input value="<?= e($profile['village']) ?>" readonly></div>
    <div class="field"><label><?= e(text_hi('मुख्य फसल', 'Primary Crop')) ?></label><input value="<?= e($profile['primary_crop']) ?>" readonly></div>
    <a class="btn btn-primary" href="<?= url('farmer/edit-profile.php') ?>"><i data-lucide="square-pen"></i><?= e(label_text('Edit Profile')) ?></a>
  </form>
</section>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('अन्य', 'More')) ?></h2><span class="badge"><?= e(label_text('Settings')) ?></span></div>
  <div class="list">
    <a class="list-row" href="<?= url('farmer/advisory.php') ?>"><div class="status-icon ok"><i data-lucide="headphones"></i></div><div><strong><?= e(text_hi('सलाह और अधिकारी सहायता', 'Advisory & Officer Help')) ?></strong><span><?= e(text_hi('संपर्क और सत्यापन सुझाव।', 'Contacts and verification tips.')) ?></span></div><i data-lucide="chevron-right"></i></a>
    <a class="list-row" href="<?= url('farmer/crop-profile.php') ?>"><div class="status-icon ok"><i data-lucide="wheat"></i></div><div><strong><?= e(label_text('Crop Profile')) ?></strong><span><?= e(text_hi('जमीन, फसल, मौसम और फील्ड नोट्स।', 'Land, crops, season, and field notes.')) ?></span></div><i data-lucide="chevron-right"></i></a>
    <a class="list-row" href="<?= url('farmer/settings.php') ?>"><div class="status-icon warn"><i data-lucide="settings"></i></div><div><strong><?= e(label_text('Settings')) ?></strong><span><?= e(text_hi('भाषा, अलर्ट, गोपनीयता और ऐप जानकारी।', 'Language, alerts, privacy, and app info.')) ?></span></div><i data-lucide="chevron-right"></i></a>
    <a class="list-row" href="<?= url('logout.php') ?>"><div class="status-icon bad"><i data-lucide="log-out"></i></div><div><strong><?= e(text_hi('लॉगआउट', 'Logout')) ?></strong><span><?= e(text_hi('किसान सत्र समाप्त करें।', 'End this farmer session.')) ?></span></div><i data-lucide="chevron-right"></i></a>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
