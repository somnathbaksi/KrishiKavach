<?php
require_once __DIR__ . '/../helpers.php';
$admin = $admin ?? require_admin();
?>
<?php require __DIR__ . '/head.php'; ?>
<main class="phone has-tabbar">
  <section class="screen">
    <header class="appbar">
      <div class="title-row">
        <?php if (!empty($back)): ?>
          <a class="icon-btn" href="<?= e($back) ?>"><i data-lucide="arrow-left"></i></a>
        <?php else: ?>
          <div class="brand-mark logo-mark"><img src="<?= url('assets/img/favicon.png') ?>" alt="Krishi Kavach"></div>
        <?php endif; ?>
        <div class="title-text"><h1><?= e(label_text($pageTitle ?? 'Admin Panel')) ?></h1><span><?= e($pageSubtitle ?? text_hi('एडमिन नियंत्रण', 'Admin control')) ?></span></div>
      </div>
      <div style="display: flex; gap: 8px; align-items: center;">
        <a class="badge" href="<?= e(lang_url(current_lang() === 'hi' ? 'en' : 'hi')) ?>"><?= current_lang() === 'hi' ? 'EN' : 'हिं' ?></a>
        <a class="icon-btn" href="<?= url('admin/settings.php') ?>"><i data-lucide="settings"></i></a>
      </div>
    </header>
