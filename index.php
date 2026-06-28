<?php
require_once __DIR__ . '/app/helpers.php';

$user = current_user();
$target = $user
    ? (($user['role'] ?? '') === 'admin' ? url('admin/dashboard.php') : url('farmer/dashboard.php'))
    : url('login.php');
$title = 'Krishi Kavach';
require __DIR__ . '/app/partials/head.php';
?>
<main class="phone">
  <section class="splash-screen">
    <div class="brand-row">
      <div class="brand-mark logo-mark"><img src="<?= url('assets/img/favicon.png') ?>" alt="Krishi Kavach"></div>
      <div class="brand-text"><strong>Krishi Kavach</strong><span><?= e(text_hi('किसान सुरक्षा प्लेटफॉर्म', 'Farmer protection platform')) ?></span></div>
    </div>

    <div class="splash-logo-card">
      <img class="app-logo-full" src="<?= url('assets/img/krishi-kavach-logo.png') ?>" alt="Krishi Kavach">
    </div>

    <div class="splash-copy">
      <h1><?= e(text_hi('नकली कृषि उत्पादों से किसान की सुरक्षा।', 'Protect farmers from fake agri products.')) ?></h1>
      <p><?= e(text_hi('बीज, खाद और कीटनाशक की जांच करें, जियो टैग सबूत सेव करें और शिकायत रिपोर्ट तैयार करें।', 'Verify seed, fertilizer, and pesticide products, save geotagged evidence, and prepare complaint reports.')) ?></p>
      <div class="splash-loader" aria-label="Loading"><span></span></div>
      <div class="actions">
        <a class="btn btn-yellow" href="<?= e($target) ?>"><i data-lucide="shield-check"></i><?= e(text_hi('ऐप खोलें', 'Open App')) ?></a>
        <a class="btn btn-ghost" href="<?= e(lang_url(current_lang() === 'hi' ? 'en' : 'hi')) ?>"><?= current_lang() === 'hi' ? 'English' : 'हिन्दी' ?></a>
      </div>
    </div>
  </section>
</main>
<script>
  setTimeout(() => {
    window.location.href = <?= json_encode($target) ?>;
  }, 2600);
</script>
<script src="<?= url('assets/js/mobile.js') ?>"></script>
</body>
</html>
