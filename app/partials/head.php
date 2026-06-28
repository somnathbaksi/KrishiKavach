<?php require_once __DIR__ . '/../helpers.php'; ?>
<!DOCTYPE html>
<html lang="<?= current_lang() === 'hi' ? 'hi' : 'en' ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= e($title ?? 'Krishi Kavach AI') ?></title>
  <link rel="icon" type="image/png" href="<?= url('assets/img/favicon.png') ?>">
  <link rel="apple-touch-icon" href="<?= url('assets/img/favicon.png') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= url('assets/css/mobile.css') ?>">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
