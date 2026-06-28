<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$crop = fetch_one('SELECT * FROM crop_profiles WHERE user_id = ? ORDER BY id DESC LIMIT 1', [$user['id']]);
$title = 'Crop Profile | Krishi Kavach AI';
$pageTitle = 'Crop Profile';
$pageSubtitle = 'Fields and season';
$activeTab = 'profile';
$back = url('farmer/profile.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="metric-grid"><div class="metric"><i data-lucide="wheat"></i><div><strong><?= e($crop['crop_name']) ?></strong><span>Primary crop</span></div></div><div class="metric"><i data-lucide="map"></i><div><strong><?= e($crop['land_area']) ?></strong><span>Land area</span></div></div></section>
<section class="card"><form class="form"><div class="field"><label>Season</label><input value="<?= e($crop['season']) ?>" readonly></div><div class="field"><label>Field Notes</label><textarea readonly><?= e($crop['field_notes']) ?></textarea></div></form></section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
