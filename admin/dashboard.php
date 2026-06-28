<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
$stats = [
    'farmers' => (int) fetch_one('SELECT COUNT(*) c FROM users WHERE role = "farmer"', [])['c'],
    'cases' => (int) fetch_one('SELECT COUNT(*) c FROM cases', [])['c'],
    'high' => (int) fetch_one('SELECT COUNT(*) c FROM cases WHERE risk_level = "High"', [])['c'],
    'reports' => (int) fetch_one('SELECT COUNT(*) c FROM reports WHERE status IN ("Ready","Submitted")', [])['c'],
];
$recentCases = fetch_all('SELECT c.*, u.name farmer_name FROM cases c JOIN users u ON u.id = c.user_id ORDER BY c.created_at DESC, c.id DESC LIMIT 4');
$title = 'Admin Dashboard | Krishi Kavach AI';
$pageTitle = 'Admin Panel';
$pageSubtitle = text_hi('कुल सिस्टम स्थिति', 'System overview');
$activeTab = 'dashboard';
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="hero">
  <h1><?= e(text_hi('कृषि सुरक्षा प्रशासन', 'Krishi protection admin')) ?></h1>
  <p><?= e(text_hi('किसानों, संदिग्ध उत्पादों, सबूत और शिकायत रिपोर्ट को एक जगह से प्रबंधित करें।', 'Manage farmers, suspicious products, evidence, and complaint reports from one place.')) ?></p>
  <div class="actions"><a class="btn btn-yellow" href="<?= url('admin/cases.php') ?>"><i data-lucide="folder-open"></i><?= e(text_hi('केस देखें', 'View Cases')) ?></a><a class="btn btn-ghost" href="<?= url('admin/reports.php') ?>"><i data-lucide="file-warning"></i><?= e(text_hi('रिपोर्ट', 'Reports')) ?></a></div>
</section>
<section class="metric-grid">
  <div class="metric"><i data-lucide="users"></i><div><strong><?= $stats['farmers'] ?></strong><span><?= e(text_hi('किसान', 'Farmers')) ?></span></div></div>
  <div class="metric"><i data-lucide="folder-open"></i><div><strong><?= $stats['cases'] ?></strong><span><?= e(text_hi('कुल केस', 'Total cases')) ?></span></div></div>
  <div class="metric"><i data-lucide="triangle-alert"></i><div><strong><?= $stats['high'] ?></strong><span><?= e(text_hi('उच्च जोखिम', 'High risk')) ?></span></div></div>
  <div class="metric"><i data-lucide="file-check-2"></i><div><strong><?= $stats['reports'] ?></strong><span><?= e(text_hi('रिपोर्ट तैयार', 'Reports ready')) ?></span></div></div>
</section>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('हाल के केस', 'Recent Cases')) ?></h2><span class="badge yellow"><?= count($recentCases) ?></span></div>
  <div class="list">
    <?php foreach ($recentCases as $case): ?>
      <a class="list-row" href="<?= url('admin/case-detail.php?id=' . (int) $case['id']) ?>"><div class="status-icon <?= status_class($case['risk_level']) ?>"><i data-lucide="folder-open"></i></div><div><strong><?= e($case['case_no']) ?> - <?= e($case['product_name']) ?></strong><span><?= e($case['farmer_name']) ?>, <?= e(label_text($case['product_type'])) ?></span></div><span class="badge <?= badge_class($case['risk_level']) ?>"><?= e(label_text($case['risk_level'])) ?></span></a>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
