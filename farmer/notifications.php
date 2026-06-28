<?php
require_once __DIR__ . '/../app/helpers.php';
$user = require_login();
$items = fetch_all('SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC', [$user['id']]);
$title = 'Notifications | Krishi Kavach AI';
$pageTitle = 'Notifications';
$pageSubtitle = text_hi('अलर्ट और रिमाइंडर', 'Alerts and reminders');
$activeTab = '';
$back = url('farmer/dashboard.php');
require __DIR__ . '/../app/partials/farmer-head.php';
?>
<section class="card">
  <div class="card-head"><h2><?= e(text_hi('हाल के अलर्ट', 'Recent Alerts')) ?></h2><span class="badge yellow"><?= count(array_filter($items, fn($n) => !$n['is_read'])) ?> <?= e(text_hi('नए', 'unread')) ?></span></div>
  <div class="list">
    <?php foreach ($items as $item): ?>
      <a class="list-row" href="<?= url('farmer/notification-detail.php?id=' . (int) $item['id']) ?>"><div class="status-icon <?= e($item['severity']) ?>"><i data-lucide="<?= $item['severity'] === 'bad' ? 'triangle-alert' : 'bell' ?>"></i></div><div><strong><?= e($item['title']) ?></strong><span><?= e($item['message']) ?></span></div><span class="badge <?= badge_class($item['severity']) ?>"><?= $item['is_read'] ? e(label_text('Read')) : e(label_text('New')) ?></span></a>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/../app/partials/farmer-foot.php'; ?>
