<?php
require_once '../config.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>
<?php include 'partials/header.php'; ?>
<h2>Admin Anasayfa</h2>
<p>Buradan ajansları yönetebilir ve ayarları düzenleyebilirsiniz.</p>
<?php include 'partials/footer.php'; ?>
