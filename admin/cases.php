<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
$cases = fetch_all('SELECT c.*, u.name farmer_name FROM cases c JOIN users u ON u.id = c.user_id ORDER BY FIELD(c.risk_level, "High","Medium","Low"), c.id DESC');
$title = 'Cases | Krishi Kavach AI';
$pageTitle = text_hi('केस', 'Cases');
$pageSubtitle = text_hi('सभी किसान केस', 'All farmer cases');
$activeTab = 'cases';
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('केस सूची', 'Case List')) ?></h2><span class="badge yellow"><?= count($cases) ?></span></div>
  <div class="list">
    <?php foreach ($cases as $case): ?>
      <a class="list-row" href="<?= url('admin/case-detail.php?id=' . (int) $case['id']) ?>"><div class="status-icon <?= status_class($case['risk_level']) ?>"><i data-lucide="folder-open"></i></div><div><strong><?= e($case['case_no']) ?> · <?= e($case['product_name']) ?></strong><span><?= e($case['farmer_name']) ?> · <?= e(label_text($case['product_type'])) ?> · <?= e($case['batch_no']) ?></span></div><span class="badge <?= badge_class($case['risk_level']) ?>"><?= e(label_text($case['risk_level'])) ?></span></a>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
