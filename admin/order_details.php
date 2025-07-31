<?php
require_once '../config.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT o.*, a.agency_name FROM orders o JOIN agencies a ON o.agency_id=a.id WHERE o.id=?');
$stmt->execute([$id]);
$order = $stmt->fetch();
if (!$order) {
    echo 'Sipariş bulunamadı';
    exit;
}
?>
<?php include 'partials/header.php'; ?>
<h2>Sipariş Detayı</h2>
<ul class="list-group mb-4">
    <li class="list-group-item"><strong>Ajans:</strong> <?php echo htmlspecialchars($order['agency_name']); ?></li>
    <li class="list-group-item"><strong>Sipariş Adı:</strong> <?php echo htmlspecialchars($order['order_name']); ?></li>
    <li class="list-group-item"><strong>Tutar:</strong> <?php echo number_format($order['total'],2); ?> ₺</li>
    <li class="list-group-item"><strong>Tarih:</strong> <?php echo htmlspecialchars($order['created_at']); ?></li>
</ul>
<a href="agency_details.php?id=<?php echo $order['agency_id']; ?>" class="btn btn-secondary">Geri</a>
<?php include 'partials/footer.php'; ?>
