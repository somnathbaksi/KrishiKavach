<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    db()->prepare('INSERT INTO officers (name, designation, area, phone) VALUES (?, ?, ?, ?)')->execute([trim($_POST['name']), trim($_POST['designation']), trim($_POST['area']), trim($_POST['phone'])]);
    redirect('admin/officers.php');
}
$officers = fetch_all('SELECT * FROM officers ORDER BY id DESC');
$title = 'Officers | Krishi Kavach AI';
$pageTitle = text_hi('अधिकारी', 'Officers');
$pageSubtitle = text_hi('सहायता निर्देशिका', 'Support directory');
$activeTab = 'more';
$back = url('admin/more.php');
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('नया अधिकारी जोड़ें', 'Add Officer')) ?></h2><span class="badge">+</span></div>
  <form class="form" method="post">
    <div class="field"><label><?= e(text_hi('नाम', 'Name')) ?></label><input name="name" required></div>
    <div class="field"><label><?= e(text_hi('पद', 'Designation')) ?></label><input name="designation" required></div>
    <div class="field"><label><?= e(text_hi('क्षेत्र', 'Area')) ?></label><input name="area" required></div>
    <div class="field"><label><?= e(text_hi('फोन', 'Phone')) ?></label><input name="phone" required></div>
    <button class="btn btn-primary" type="submit"><?= e(text_hi('सेव करें', 'Save')) ?></button>
  </form>
</section>
<section class="card"><div class="list">
<?php foreach ($officers as $officer): ?>
  <div class="list-row"><div class="status-icon ok"><i data-lucide="building-2"></i></div><div><strong><?= e($officer['name']) ?></strong><span><?= e($officer['designation']) ?> · <?= e($officer['area']) ?></span></div><a class="badge green" href="tel:<?= e($officer['phone']) ?>"><?= e(text_hi('कॉल', 'Call')) ?></a></div>
<?php endforeach; ?>
</div></section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
