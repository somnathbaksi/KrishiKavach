<?php
require_once __DIR__ . '/app/actions.php';
$title = 'Register | Krishi Kavach AI';
$error = handle_register();
require __DIR__ . '/app/partials/auth-shell.php';
?>
<div class="auth-title"><h1><?= e(text_hi('खाता बनाएं', 'Create account')) ?></h1><p><?= e(text_hi('किसान खाता सेट करें।', 'Set up a farmer account.')) ?></p></div>
<?php if ($error): ?><div class="badge red"><?= e($error) ?></div><?php endif; ?>
<form class="form" method="post">
  <div class="field"><label for="name"><?= e(text_hi('पूरा नाम', 'Full Name')) ?></label><input id="name" name="name" type="text" placeholder="Ramesh Patil"></div>
  <div class="field"><label for="mobile"><?= e(text_hi('मोबाइल नंबर', 'Mobile Number')) ?></label><input id="mobile" name="mobile" type="tel" placeholder="9876543210"></div>
  <div class="field"><label for="village"><?= e(text_hi('गांव', 'Village')) ?></label><input id="village" name="village" type="text" placeholder="Tasgaon"></div>
  <div class="field"><label for="password"><?= e(text_hi('पासवर्ड', 'Password')) ?></label><input id="password" name="password" type="password" placeholder="<?= e(text_hi('कम से कम 6 अक्षर', 'Minimum 6 characters')) ?>"></div>
  <button class="btn btn-primary" type="submit"><i data-lucide="user-plus"></i><?= e(text_hi('खाता बनाएं', 'Create Account')) ?></button>
</form>
<div class="auth-links"><span><?= e(text_hi('पहले से पंजीकृत?', 'Already registered?')) ?></span><a href="<?= url('login.php') ?>"><?= e(text_hi('लॉगिन', 'Login')) ?></a></div>
<?php require __DIR__ . '/app/partials/auth-end.php'; ?>
