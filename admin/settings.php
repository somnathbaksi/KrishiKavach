<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
$title = 'Admin Settings | Krishi Kavach AI';
$pageTitle = text_hi('सेटिंग्स', 'Settings');
$pageSubtitle = text_hi('एडमिन प्राथमिकताएं', 'Admin preferences');
$activeTab = 'more';
$back = url('admin/more.php');
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card"><div class="list">
  <div class="list-row"><div class="status-icon ok"><i data-lucide="languages"></i></div><div><strong><?= e(text_hi('भाषा', 'Language')) ?></strong><span><?= e(text_hi('डिफॉल्ट हिन्दी, दूसरी भाषा English', 'Default Hindi, secondary English')) ?></span></div><a class="badge" href="<?= e(lang_url(current_lang() === 'hi' ? 'en' : 'hi')) ?>"><?= current_lang() === 'hi' ? 'English' : 'हिन्दी' ?></a></div>
  <div class="list-row"><div class="status-icon ok"><i data-lucide="database"></i></div><div><strong><?= e(text_hi('डेटाबेस', 'Database')) ?></strong><span>krishikavach · localhost · root</span></div><span class="badge green">OK</span></div>
  <a class="list-row" href="<?= url('logout.php') ?>"><div class="status-icon bad"><i data-lucide="log-out"></i></div><div><strong><?= e(text_hi('लॉगआउट', 'Logout')) ?></strong><span><?= e(text_hi('एडमिन सत्र समाप्त करें', 'End admin session')) ?></span></div><i data-lucide="chevron-right"></i></a>
</div></section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
