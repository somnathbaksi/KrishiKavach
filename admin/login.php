<?php
require_once __DIR__ . '/../app/admin_actions.php';
$title = 'Admin Login | Krishi Kavach AI';
$error = handle_admin_login();
require __DIR__ . '/../app/partials/auth-shell.php';
?>
<div class="auth-title"><h1><?= e(text_hi('एडमिन लॉगिन', 'Admin Login')) ?></h1><p><?= e(text_hi('किसान पैनल, केस, रिपोर्ट और अधिकारी डेटा प्रबंधित करें।', 'Manage farmer panel, cases, reports, and officer data.')) ?></p></div>
<?php if ($error): ?><div class="badge red"><?= e($error) ?></div><?php endif; ?>
<form class="form" method="post">
  <div class="field"><label><?= e(text_hi('मोबाइल या ईमेल', 'Mobile or Email')) ?></label><input name="login" type="text" value="9999999999"></div>
  <div class="field"><label><?= e(text_hi('पासवर्ड', 'Password')) ?></label><input name="password" type="password" value="admin123"></div>
  <button class="btn btn-primary" type="submit"><i data-lucide="shield-check"></i><?= e(text_hi('एडमिन प्रवेश', 'Admin Login')) ?></button>
  <a class="btn btn-outline" href="<?= url('login.php') ?>"><?= e(text_hi('किसान लॉगिन', 'Farmer Login')) ?></a>
</form>
<?php require __DIR__ . '/../app/partials/auth-end.php'; ?>
