<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
db()->prepare('UPDATE reports SET status = "Submitted" WHERE user_id = ? ORDER BY id DESC LIMIT 1')->execute([$user['id']]);
$title = 'Submitted | Krishi Kavach AI';
require __DIR__ . '/../app/partials/head.php';
?>
<main class="phone">
  <section class="screen" style="display: grid; align-content: center;">
    <section class="card" style="text-align: center;">
      <div class="status-icon ok" style="width: 72px; height: 72px; margin: 0 auto 14px;"><i data-lucide="check"></i></div>
      <h1 style="margin: 0 0 8px;">Report Submitted</h1>
      <p class="muted" style="line-height: 1.6;">Your case was marked submitted for officer review. Keep original product packet and bill safely.</p>
      <div class="actions" style="margin-top: 16px;"><a class="btn btn-outline" href="<?= url('farmer/case-detail.php') ?>">View Case</a><a class="btn btn-primary" href="<?= url('farmer/dashboard.php') ?>">Dashboard</a></div>
    </section>
  </section>
</main>
<script src="<?= url('assets/js/mobile.js') ?>"></script>
</body>
</html>
