  </section>
  <nav class="tabbar">
    <a<?= active_tab('dashboard', $activeTab ?? '') ?> href="<?= url('admin/dashboard.php') ?>"><i data-lucide="layout-dashboard"></i><?= e(text_hi('डैश', 'Dash')) ?></a>
    <a<?= active_tab('farmers', $activeTab ?? '') ?> href="<?= url('admin/farmers.php') ?>"><i data-lucide="users"></i><?= e(text_hi('किसान', 'Farmers')) ?></a>
    <a<?= active_tab('cases', $activeTab ?? '') ?> href="<?= url('admin/cases.php') ?>"><i data-lucide="folder-open"></i><?= e(text_hi('केस', 'Cases')) ?></a>
    <a<?= active_tab('reports', $activeTab ?? '') ?> href="<?= url('admin/reports.php') ?>"><i data-lucide="file-warning"></i><?= e(text_hi('रिपोर्ट', 'Reports')) ?></a>
    <a<?= active_tab('more', $activeTab ?? '') ?> href="<?= url('admin/more.php') ?>"><i data-lucide="menu"></i><?= e(text_hi('और', 'More')) ?></a>
  </nav>
</main>
<script src="<?= url('assets/js/mobile.js') ?>"></script>
</body>
</html>
