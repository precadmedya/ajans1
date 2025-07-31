<?php
require_once __DIR__.'/../../config.php';
$s = $pdo->query('SELECT logo_url FROM settings LIMIT 1')->fetch();
$logoUrl = $s['logo_url'] ?? '../uploads/logo.png';
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
        <a class="navbar-brand" href="agency_requests.php">
            <img src="../<?php echo htmlspecialchars($logoUrl); ?>" alt="Logo" width="30" height="30" class="me-2">
            Admin Paneli
        </a>
        <?php if(isset($_SESSION['admin_id'])): ?>
        <div class="d-flex">
            <a href="agency_requests.php" class="btn btn-sm btn-outline-light me-2">Ajanslar</a>
            <a href="settings.php" class="btn btn-sm btn-outline-light me-2">Ayarlar</a>
            <a href="logout.php" class="btn btn-sm btn-outline-light">Çıkış</a>
        </div>
        <?php endif; ?>
    </div>
</nav>
<div class="container">
