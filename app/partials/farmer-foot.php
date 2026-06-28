  </section>
  <nav class="tabbar">
    <a<?= active_tab('home', $activeTab ?? '') ?> href="<?= url('farmer/dashboard.php') ?>"><i data-lucide="home"></i><?= e(label_text('Home')) ?></a>
    <a<?= active_tab('scan', $activeTab ?? '') ?> href="<?= url('farmer/scan.php') ?>"><i data-lucide="scan-line"></i><?= e(label_text('Scan')) ?></a>
    <a<?= active_tab('locker', $activeTab ?? '') ?> href="<?= url('farmer/locker.php') ?>"><i data-lucide="folder-lock"></i><?= e(label_text('Locker')) ?></a>
    <a<?= active_tab('report', $activeTab ?? '') ?> href="<?= url('farmer/report.php') ?>"><i data-lucide="file-warning"></i><?= e(label_text('Report')) ?></a>
    <a<?= active_tab('profile', $activeTab ?? '') ?> href="<?= url('farmer/profile.php') ?>"><i data-lucide="user-round"></i><?= e(label_text('Profile')) ?></a>
  </nav>
</main>
<script src="<?= url('assets/js/mobile.js') ?>"></script>
</body>
</html>
