<?php
require_once __DIR__.'/../../config.php';
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
        <span class="navbar-brand mb-0 h1">Admin Paneli</span>
        <?php if(isset($_SESSION['admin_id'])): ?>
            <a href="logout.php" class="btn btn-sm btn-outline-light">Çıkış</a>
        <?php endif; ?>
    </div>
</nav>
<div class="container">
