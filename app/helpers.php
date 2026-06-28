<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function current_lang(): string
{
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['hi', 'en'], true)) {
        $_SESSION['lang'] = $_GET['lang'];
    }

    return $_SESSION['lang'] ?? 'hi';
}

function text_hi(string $hi, string $en): string
{
    return current_lang() === 'hi' ? $hi : $en;
}

function lang_url(string $lang): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: APP_BASE . '/';
    $query = $_GET;
    $query['lang'] = $lang;
    return $path . '?' . http_build_query($query);
}

function label_text(string $value): string
{
    $map = [
        'Home' => 'होम',
        'Scan' => 'स्कैन',
        'Locker' => 'लॉकर',
        'Report' => 'रिपोर्ट',
        'Profile' => 'प्रोफाइल',
        'Dashboard' => 'डैशबोर्ड',
        'Product Scan' => 'उत्पाद स्कैन',
        'Scan History' => 'स्कैन इतिहास',
        'Scan Detail' => 'स्कैन विवरण',
        'Evidence Locker' => 'सबूत लॉकर',
        'Evidence Attached' => 'जुड़े सबूत',
        'Upload Evidence' => 'सबूत अपलोड करें',
        'Case Detail' => 'केस विवरण',
        'Case Timeline' => 'केस समयरेखा',
        'Complaint Report' => 'शिकायत रिपोर्ट',
        'Report Preview' => 'रिपोर्ट पूर्वावलोकन',
        'Notifications' => 'सूचनाएं',
        'Notification Detail' => 'सूचना विवरण',
        'Settings' => 'सेटिंग्स',
        'Advisory' => 'सलाह',
        'Product Database' => 'उत्पाद डेटाबेस',
        'Crop Profile' => 'फसल प्रोफाइल',
        'Edit Profile' => 'प्रोफाइल संपादित करें',
        'Farmer Panel' => 'किसान पैनल',
        'High' => 'उच्च',
        'Medium' => 'मध्यम',
        'Low' => 'कम',
        'Ready' => 'तैयार',
        'Draft' => 'ड्राफ्ट',
        'Submitted' => 'जमा',
        'Clear' => 'स्पष्ट',
        'Retake' => 'फिर लें',
        'New' => 'नया',
        'Read' => 'पढ़ा गया',
        'Product Photo' => 'उत्पाद फोटो',
        'QR Photo' => 'QR फोटो',
        'Purchase Bill' => 'खरीद बिल',
        'Crop Damage' => 'फसल नुकसान',
        'Dealer Note' => 'डीलर नोट',
        'Officer Note' => 'अधिकारी नोट',
        'Seeds' => 'बीज',
        'Fertilizer' => 'खाद',
        'Pesticide' => 'कीटनाशक',
    ];

    return current_lang() === 'hi' ? ($map[$value] ?? $value) : $value;
}

function url(string $path = ''): string
{
    return APP_BASE . '/' . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    return fetch_one('SELECT * FROM users WHERE id = ?', [(int) $_SESSION['user_id']]);
}

function require_login(): array
{
    $user = current_user();
    if (!$user) {
        redirect('login.php');
    }
    return $user;
}

function require_admin(): array
{
    $user = require_login();
    if (($user['role'] ?? '') !== 'admin') {
        redirect('admin/login.php');
    }
    return $user;
}

function badge_class(string $value): string
{
    return match (strtolower($value)) {
        'high', 'bad', 'retake', 'failed' => 'red',
        'medium', 'warn', 'review', 'pending', 'draft' => 'yellow',
        default => 'green',
    };
}

function status_class(string $value): string
{
    return match (strtolower($value)) {
        'high', 'bad', 'retake', 'failed' => 'bad',
        'medium', 'warn', 'review', 'pending', 'draft' => 'warn',
        default => 'ok',
    };
}

function active_tab(string $tab, string $active): string
{
    return $tab === $active ? ' class="active"' : '';
}
