<?php
require_once __DIR__.'/../../config.php';
$s = $pdo->query('SELECT logo_url, logo_width, logo_height, header_bg, header_color FROM settings LIMIT 1')->fetch();
$logoUrl = $s['logo_url'] ?? '../uploads/logo.png';
$logoW = $s['logo_width'] ?? 30;
$logoH = $s['logo_height'] ?? 30;
$headerBg = $s['header_bg'] ?? '#343a40';
$headerColor = $s['header_color'] ?? '#ffffff';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar mb-4" style="background-color: <?php echo htmlspecialchars($headerBg); ?>;">
    <div class="container align-items-center">
        <a class="navbar-brand" href="index.php" style="color: <?php echo htmlspecialchars($headerColor); ?>;">
            <img src="../<?php echo htmlspecialchars($logoUrl); ?>" alt="Logo" width="<?php echo (int)$logoW; ?>" height="<?php echo (int)$logoH; ?>" class="me-2">
            Admin Paneli
        </a>
        <?php if(isset($_SESSION['admin_id'])): ?>
        <div class="d-flex flex-grow-1 justify-content-center">
            <a href="index.php" class="nav-link" style="color: <?php echo htmlspecialchars($headerColor); ?>;">Anasayfa</a>
            <a href="agencies.php" class="nav-link mx-3" style="color: <?php echo htmlspecialchars($headerColor); ?>;">Ajanslar</a>
            <a href="services.php" class="nav-link mx-3" style="color: <?php echo htmlspecialchars($headerColor); ?>;">Hizmetler</a>
            <a href="orders.php" class="nav-link mx-3" style="color: <?php echo htmlspecialchars($headerColor); ?>;">Siparişler</a>
            <a href="settings.php" class="nav-link" style="color: <?php echo htmlspecialchars($headerColor); ?>;">Ayarlar</a>
        </div>
        <a href="logout.php" class="btn btn-sm btn-outline-light">Çıkış</a>
        <?php endif; ?>
    </div>
</nav>
<div class="container">
