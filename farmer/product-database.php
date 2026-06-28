<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$products = fetch_all('SELECT product_name, product_type, risk_level, MAX(scanned_at) scanned_at FROM product_scans WHERE user_id = ? GROUP BY product_name, product_type, risk_level ORDER BY scanned_at DESC', [$user['id']]);
$title = 'Product Database | Krishi Kavach AI';
$pageTitle = 'Product Database';
$pageSubtitle = 'Known label patterns';
$activeTab = 'scan';
$back = url('farmer/scan.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card"><form class="form"><div class="field"><label>Search Product</label><input type="search" placeholder="Seed, fertilizer, pesticide"></div></form></section>
<section class="card">
  <div class="list">
    <?php foreach ($products as $product): ?>
      <div class="list-row"><div class="status-icon <?= status_class($product['risk_level']) ?>"><i data-lucide="package-search"></i></div><div><strong><?= e($product['product_name']) ?></strong><span><?= e($product['product_type']) ?> label pattern history.</span></div><span class="badge <?= badge_class($product['risk_level']) ?>"><?= e($product['risk_level']) ?></span></div>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
