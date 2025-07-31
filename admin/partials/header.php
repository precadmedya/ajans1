<?php
require_once __DIR__.'/../../config.php';
$s = $pdo->query('SELECT logo_url, logo_width, logo_height FROM settings LIMIT 1')->fetch();
$logoUrl = $s['logo_url'] ?? '../uploads/logo.png';
$logoW = $s['logo_width'] ?? 30;
$logoH = $s['logo_height'] ?? 30;
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
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="../<?php echo htmlspecialchars($logoUrl); ?>" alt="Logo" width="<?php echo (int)$logoW; ?>" height="<?php echo (int)$logoH; ?>" class="me-2">
            Admin Paneli
        </a>
        <?php if(isset($_SESSION['admin_id'])): ?>
        <div class="d-flex">
            <a href="index.php" class="btn btn-sm btn-outline-light me-2">Anasayfa</a>
            <a href="agencies.php" class="btn btn-sm btn-outline-light me-2">Ajanslar</a>
            <a href="settings.php" class="btn btn-sm btn-outline-light me-2">Ayarlar</a>
            <a href="logout.php" class="btn btn-sm btn-outline-light">Çıkış</a>
        </div>
        <?php endif; ?>
    </div>
</nav>
<div class="container">
