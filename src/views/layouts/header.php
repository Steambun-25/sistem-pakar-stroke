<!-- File: src/views/layouts/header.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'StrokeCare' ?></title>
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
</head>
<body>

<header class="main-header">
    <div class="main-container header-content">
        <a href="<?= url('home') ?>" class="brand-logo">StrokeCare</a>
        <nav class="main-nav">
            <?php if (isLoggedIn()): ?>
                <a href="<?= url('dashboard') ?>">Dashboard</a>
                <span>|</span>
                <span style="color: #666;">Login sebagai: <?= htmlspecialchars($_SESSION['user_nama']) ?></span>
                <a href="<?= url('logout') ?>" style="font-weight: 600; color: var(--primary-color);">Keluar</a>
            <?php else: ?>
                <a href="<?= url('home') ?>">Home</a>
                <a href="<?= url('login') ?>">Login</a>
                <a href="<?= url('register') ?>">Sign Up</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<!-- Tag 'main' ini akan membungkus semua konten halaman -->
<main class="page-wrapper">
<!-- Konten spesifik halaman (home, login, dll.) akan dimulai setelah ini -->
