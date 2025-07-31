<?php
require_once __DIR__.'/../config.php';
$s = $pdo->query('SELECT logo_url, logo_width, logo_height, header_bg, header_color FROM settings LIMIT 1')->fetch();
$logoUrl = $s['logo_url'] ?? 'uploads/logo.png';
$logoW = $s['logo_width'] ?? 40;
$logoH = $s['logo_height'] ?? 40;
$headerBg = $s['header_bg'] ?? '#f8f9fa';
$headerColor = $s['header_color'] ?? '#000000';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yazılım Ustası</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body style="font-family: 'Poppins', sans-serif;">
<header class="py-3 mb-4 border-bottom" style="background-color: <?php echo htmlspecialchars($headerBg); ?>;">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
        <a href="/" class="d-flex align-items-center text-decoration-none" style="color: <?php echo htmlspecialchars($headerColor); ?>;">
            <img src="/<?php echo htmlspecialchars($logoUrl); ?>" alt="Logo" width="<?php echo (int)$logoW; ?>" height="<?php echo (int)$logoH; ?>" class="me-2">
            <span class="fs-4">Yazılım Ustası</span>
        </a>
        <?php if(isset($_SESSION['agency_id'])): ?>
            <nav>
                <a href="dashboard.php" class="me-3" style="color: <?php echo htmlspecialchars($headerColor); ?>;">Anasayfa</a>
                <a href="order_create.php" class="me-3" style="color: <?php echo htmlspecialchars($headerColor); ?>;">Sipariş Ver</a>
                <a href="orders.php" class="me-3" style="color: <?php echo htmlspecialchars($headerColor); ?>;">Siparişlerim</a>
                <a href="logout.php" style="color: <?php echo htmlspecialchars($headerColor); ?>;">Çıkış</a>
            </nav>
        <?php endif; ?>
    </div>
</header>
<div class="container">
