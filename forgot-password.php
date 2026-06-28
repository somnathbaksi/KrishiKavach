<?php $title = 'Forgot Password | Krishi Kavach AI'; require __DIR__ . '/app/partials/auth-shell.php'; ?>
<div class="auth-title"><h1><?= e(text_hi('पासवर्ड भूल गए', 'Forgot password')) ?></h1><p><?= e(text_hi('OTP प्राप्त करने के लिए पंजीकृत मोबाइल या ईमेल दर्ज करें।', 'Enter registered mobile or email to receive an OTP.')) ?></p></div>
<form class="form">
  <div class="field"><label for="resetId"><?= e(text_hi('मोबाइल या ईमेल', 'Mobile or Email')) ?></label><input id="resetId" type="text" placeholder="9876543210"></div>
  <a class="btn btn-primary" href="<?= url('otp-verification.php') ?>"><i data-lucide="send"></i><?= e(text_hi('OTP भेजें', 'Send OTP')) ?></a>
</form>
<div class="auth-links"><a href="<?= url('login.php') ?>"><?= e(text_hi('लॉगिन पर वापस जाएं', 'Back to login')) ?></a><a href="<?= url('register.php') ?>"><?= e(text_hi('रजिस्टर', 'Register')) ?></a></div>
<?php require __DIR__ . '/app/partials/auth-end.php'; ?>
