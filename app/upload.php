<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

function upload_evidence_file(array $file, string $prefix): ?array
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload failed.');
    }

    if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
        throw new RuntimeException('File size must be under 5 MB.');
    }

    $tmp = (string) $file['tmp_name'];
    $mime = mime_content_type($tmp) ?: '';
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
        'application/pdf' => 'pdf',
        'text/plain' => 'txt',
    ];

    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Only JPG, PNG, WEBP, GIF, PDF, and TXT files are allowed.');
    }

    $dir = dirname(__DIR__) . '/uploads/evidence';
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    $safePrefix = preg_replace('/[^a-zA-Z0-9_-]/', '-', $prefix) ?: 'evidence';
    $name = $safePrefix . '-' . date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];
    $target = $dir . '/' . $name;

    if (!move_uploaded_file($tmp, $target)) {
        throw new RuntimeException('Unable to save uploaded file.');
    }

    return [
        'file_name' => $name,
        'file_path' => 'uploads/evidence/' . $name,
        'original_name' => (string) ($file['name'] ?? $name),
        'mime' => $mime,
    ];
}

function evidence_is_image(?string $path): bool
{
    if (!$path) {
        return false;
    }

    return (bool) preg_match('/\.(jpe?g|png|webp|gif)$/i', $path);
}
