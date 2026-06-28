<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$id = (int) ($_GET['id'] ?? 0);
$item = fetch_one('SELECT * FROM notifications WHERE id = ? AND user_id = ?', [$id, $user['id']])
    ?? fetch_one('SELECT * FROM notifications WHERE user_id = ? ORDER BY id DESC LIMIT 1', [$user['id']]);
if ($item) {
    db()->prepare('UPDATE notifications SET is_read = 1 WHERE id = ?')->execute([$item['id']]);
}
$title = 'Notification Detail | Krishi Kavach AI';
$pageTitle = 'Notification Detail';
$pageSubtitle = 'Risk alert';
$activeTab = '';
$back = url('farmer/notifications.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card">
  <div class="risk <?= $item['severity'] === 'bad' ? 'high' : '' ?>"><div class="status-icon <?= e($item['severity']) ?>"><i data-lucide="triangle-alert"></i></div><div><h2><?= e($item['title']) ?></h2><p><?= e($item['message']) ?></p></div></div>
</section>
<section class="card">
  <div class="card-head"><h2>Recommended Action</h2><span class="badge <?= badge_class($item['severity']) ?>">Today</span></div>
  <p class="muted" style="line-height: 1.6;">Keep the original packet and bill safely. Add missing evidence, then prepare the complaint report for officer review.</p>
  <div class="actions" style="margin-top: 14px;"><a class="btn btn-outline" href="<?= url('farmer/scan-history.php') ?>"><i data-lucide="scan-line"></i>View Scan</a><a class="btn btn-primary" href="<?= url('farmer/report-preview.php') ?>"><i data-lucide="file-warning"></i>Prepare Report</a></div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
