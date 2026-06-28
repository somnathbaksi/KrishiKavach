<?php $title = 'Change Password | Krishi Kavach AI'; require __DIR__ . '/app/partials/auth-shell.php'; ?>
<div class="auth-title"><h1><?= e(text_hi('पासवर्ड बदलें', 'Change password')) ?></h1><p><?= e(text_hi('अपने खाते के लिए नया पासवर्ड बनाएं।', 'Create a new password for your account.')) ?></p></div>
<form class="form">
  <div class="field"><label><?= e(text_hi('नया पासवर्ड', 'New Password')) ?></label><input type="password"></div>
  <div class="field"><label><?= e(text_hi('पासवर्ड पुष्टि करें', 'Confirm Password')) ?></label><input type="password"></div>
  <a class="btn btn-primary" href="<?= url('login.php') ?>"><i data-lucide="lock-keyhole"></i><?= e(text_hi('पासवर्ड अपडेट करें', 'Update Password')) ?></a>
</form>
<?php require __DIR__ . '/app/partials/auth-end.php'; ?>
