<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$officers = fetch_all('SELECT * FROM officers ORDER BY id');
$title = 'Advisory | Krishi Kavach AI';
$pageTitle = 'Advisory';
$pageSubtitle = 'Officer help and tips';
$activeTab = 'profile';
$back = url('farmer/profile.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card">
  <div class="card-head"><h2>Quick Guidance</h2><span class="badge">Advisor</span></div>
  <div class="list">
    <div class="list-row"><div class="status-icon ok"><i data-lucide="scan-search"></i></div><div><strong>Before purchase</strong><span>Check QR, batch, expiry, MRP, hologram, and bill.</span></div></div>
    <div class="list-row"><div class="status-icon warn"><i data-lucide="sprout"></i></div><div><strong>After damage</strong><span>Take field photos on day 1, day 3, and day 7.</span></div></div>
  </div>
</section>
<section class="card">
  <div class="card-head"><h2>Support Contacts</h2><span class="badge green">Nearby</span></div>
  <div class="list">
    <?php foreach ($officers as $officer): ?>
      <div class="list-row"><div class="status-icon ok"><i data-lucide="building-2"></i></div><div><strong><?= e($officer['name']) ?></strong><span><?= e($officer['designation']) ?>, <?= e($officer['area']) ?></span></div><a class="badge green" href="tel:<?= e($officer['phone']) ?>">Call</a></div>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
