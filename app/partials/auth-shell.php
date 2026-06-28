<?php require __DIR__ . '/head.php'; ?>
<main class="phone auth-screen">
  <div class="brand-row">
    <div class="brand-mark logo-mark"><img src="<?= url('assets/img/favicon.png') ?>" alt="Krishi Kavach"></div>
    <div class="brand-text"><strong>Krishi Kavach</strong><span><?= e(text_hi('किसान सुरक्षा प्लेटफॉर्म', 'Farmer protection platform')) ?></span></div>
    <a class="badge" href="<?= e(lang_url(current_lang() === 'hi' ? 'en' : 'hi')) ?>"><?= current_lang() === 'hi' ? 'English' : 'हिन्दी' ?></a>
  </div>
  <section class="auth-card">
