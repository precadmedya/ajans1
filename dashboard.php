<?php
require 'config.php';
if (!isset($_SESSION['agency_id'])) {
    header('Location: index.php');
    exit;
}
?>
<?php include 'partials/header.php'; ?>
<h2>Hoş Geldiniz</h2>
<p>Ajans kontrol paneline hoş geldiniz.</p>
<?php include 'partials/footer.php'; ?>
