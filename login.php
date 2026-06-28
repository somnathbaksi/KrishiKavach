<?php
require_once __DIR__ . '/app/actions.php';
$title = 'Login | Krishi Kavach AI';
$error = handle_login();
require __DIR__ . '/app/partials/auth-shell.php';
?>
<div class="auth-title"><h1><?= e(text_hi('लॉगिन', 'Login')) ?></h1><p><?= e(text_hi('उत्पाद स्कैन, सबूत लॉकर और शिकायत रिपोर्ट तक पहुंचें।', 'Access product scans, evidence locker, and complaint reports.')) ?></p></div>
<?php if ($error): ?><div class="badge red"><?= e($error) ?></div><?php endif; ?>
<form class="form" method="post">
  <div class="field"><label for="login"><?= e(text_hi('मोबाइल या ईमेल', 'Mobile or Email')) ?></label><input id="login" name="login" type="text" value="9876543210"></div>
  <div class="field"><label for="password"><?= e(text_hi('पासवर्ड', 'Password')) ?></label><input id="password" name="password" type="password" value="password123"></div>
  <div class="auth-links"><label><input type="checkbox"> <?= e(text_hi('याद रखें', 'Remember')) ?></label><a href="<?= url('forgot-password.php') ?>"><?= e(text_hi('पासवर्ड भूल गए?', 'Forgot password?')) ?></a></div>
  <button class="btn btn-primary" type="submit"><i data-lucide="log-in"></i><?= e(text_hi('लॉगिन', 'Login')) ?></button>
  <a class="btn btn-outline" href="<?= url('otp-verification.php') ?>"><i data-lucide="message-square-text"></i><?= e(text_hi('OTP से लॉगिन', 'Login with OTP')) ?></a>
</form>
<div class="auth-links"><span><?= e(text_hi('नए उपयोगकर्ता?', 'New user?')) ?></span><a href="<?= url('register.php') ?>"><?= e(text_hi('खाता बनाएं', 'Create account')) ?></a></div>
<?php require __DIR__ . '/app/partials/auth-end.php'; ?>
