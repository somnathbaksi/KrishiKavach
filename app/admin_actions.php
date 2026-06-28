<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

function handle_admin_login(): ?string
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
    }

    $login = trim($_POST['login'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $user = fetch_one('SELECT * FROM users WHERE (mobile = ? OR email = ?) AND role = "admin" LIMIT 1', [$login, $login]);

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return text_hi('एडमिन लॉगिन गलत है।', 'Invalid admin login.');
    }

    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['lang'] = $_SESSION['lang'] ?? 'hi';
    redirect('admin/dashboard.php');
}
