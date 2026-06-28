<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$profile = fetch_one('SELECT * FROM farmer_profiles WHERE user_id = ?', [$user['id']]);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    db()->prepare('UPDATE users SET name = ?, mobile = ? WHERE id = ?')->execute([trim($_POST['name']), trim($_POST['mobile']), $user['id']]);
    db()->prepare('UPDATE farmer_profiles SET village = ?, district = ?, primary_crop = ? WHERE user_id = ?')->execute([trim($_POST['village']), trim($_POST['district']), trim($_POST['primary_crop']), $user['id']]);
    redirect('farmer/profile.php');
}
$title = 'Edit Profile | Krishi Kavach AI';
$pageTitle = 'Edit Profile';
$pageSubtitle = 'Farmer details';
$activeTab = 'profile';
$back = url('farmer/profile.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card">
  <form class="form" method="post">
    <div class="field"><label>Name</label><input name="name" value="<?= e($user['name']) ?>"></div>
    <div class="field"><label>Mobile</label><input name="mobile" value="<?= e($user['mobile']) ?>"></div>
    <div class="field"><label>Village</label><input name="village" value="<?= e($profile['village']) ?>"></div>
    <div class="field"><label>District</label><input name="district" value="<?= e($profile['district']) ?>"></div>
    <div class="field"><label>Primary Crop</label><input name="primary_crop" value="<?= e($profile['primary_crop']) ?>"></div>
    <button class="btn btn-primary" type="submit">Save Changes</button>
  </form>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
