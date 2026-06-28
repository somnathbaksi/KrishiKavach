<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

function handle_login(): ?string
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
    }

    $login = trim($_POST['login'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $user = fetch_one('SELECT * FROM users WHERE mobile = ? OR email = ? LIMIT 1', [$login, $login]);

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return text_hi('मोबाइल/ईमेल या पासवर्ड गलत है।', 'Invalid mobile/email or password.');
    }

    $_SESSION['user_id'] = (int) $user['id'];
    if (($user['role'] ?? '') === 'admin') {
        redirect('admin/dashboard.php');
    }
    redirect('farmer/dashboard.php');
}

function handle_register(): ?string
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
    }

    $name = trim($_POST['name'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $village = trim($_POST['village'] ?? 'Tasgaon');

    if ($name === '' || $mobile === '' || strlen($password) < 6) {
        return text_hi('कृपया नाम, मोबाइल और कम से कम 6 अक्षर वाला पासवर्ड दर्ज करें।', 'Please enter name, mobile, and a password with at least 6 characters.');
    }

    $exists = fetch_one('SELECT id FROM users WHERE mobile = ?', [$mobile]);
    if ($exists) {
        return text_hi('यह मोबाइल नंबर पहले से पंजीकृत है।', 'Mobile number is already registered.');
    }

    db()->beginTransaction();
    $stmt = db()->prepare('INSERT INTO users (name, mobile, password_hash, role) VALUES (?, ?, ?, "farmer")');
    $stmt->execute([$name, $mobile, password_hash($password, PASSWORD_DEFAULT)]);
    $userId = (int) db()->lastInsertId();

    $stmt = db()->prepare('INSERT INTO farmer_profiles (user_id, village, taluka, district, land_area, primary_crop) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$userId, $village, $village, 'Sangli', '0 acres', 'Cotton']);
    db()->commit();

    $_SESSION['user_id'] = $userId;
    redirect('farmer/dashboard.php');
}
