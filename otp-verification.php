<?php $title = 'OTP Verification | Krishi Kavach AI'; require __DIR__ . '/app/partials/auth-shell.php'; ?>
<div class="auth-title"><h1><?= e(text_hi('OTP सत्यापित करें', 'Verify OTP')) ?></h1><p><?= e(text_hi('आपके मोबाइल पर भेजा गया छह अंकों का कोड दर्ज करें।', 'Enter the six-digit code sent to your mobile.')) ?></p></div>
<form class="form">
  <div class="otp-grid"><input maxlength="1"><input maxlength="1"><input maxlength="1"><input maxlength="1"><input maxlength="1"><input maxlength="1"></div>
  <a class="btn btn-primary" href="<?= url('change-password.php') ?>"><i data-lucide="badge-check"></i><?= e(text_hi('OTP सत्यापित करें', 'Verify OTP')) ?></a>
</form>
<div class="auth-links"><span><?= e(text_hi('कोड नहीं मिला?', 'Did not receive code?')) ?></span><a href="<?= url('otp-verification.php') ?>"><?= e(text_hi('फिर भेजें', 'Resend')) ?></a></div>
<?php require __DIR__ . '/app/partials/auth-end.php'; ?>
