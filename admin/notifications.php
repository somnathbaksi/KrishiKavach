<?php
require_once __DIR__ . '/../app/helpers.php';
$admin = require_admin();
$items = fetch_all('SELECT n.*, u.name farmer_name FROM notifications n JOIN users u ON u.id = n.user_id ORDER BY n.created_at DESC');
$title = 'Notifications | Krishi Kavach AI';
$pageTitle = text_hi('सूचनाएं', 'Notifications');
$pageSubtitle = text_hi('सभी अलर्ट', 'All alerts');
$activeTab = 'more';
$back = url('admin/more.php');
require __DIR__ . '/../app/partials/admin-head.php';
?>
<section class="card"><div class="list">
<?php foreach ($items as $item): ?>
  <div class="list-row"><div class="status-icon <?= e($item['severity']) ?>"><i data-lucide="bell"></i></div><div><strong><?= e($item['title']) ?></strong><span><?= e($item['farmer_name']) ?> · <?= e($item['message']) ?></span></div><span class="badge <?= badge_class($item['severity']) ?>"><?= $item['is_read'] ? e(label_text('Read')) : e(label_text('New')) ?></span></div>
<?php endforeach; ?>
</div></section>
<?php require __DIR__ . '/../app/partials/admin-foot.php'; ?>
