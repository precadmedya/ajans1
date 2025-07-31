<?php
require_once '../config.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$agencyStmt = $pdo->prepare('SELECT * FROM agencies WHERE id=?');
$agencyStmt->execute([$id]);
$agency = $agencyStmt->fetch();
if (!$agency) {
    echo 'Ajans bulunamadı';
    exit;
}

$orders = $pdo->prepare('SELECT * FROM orders WHERE agency_id=? ORDER BY created_at DESC');
$orders->execute([$id]);
$orders = $orders->fetchAll();
?>
<?php include 'partials/header.php'; ?>
<h2>Ajans Detayları</h2>
<ul class="list-group mb-4">
    <li class="list-group-item"><strong>Ajans:</strong> <?php echo htmlspecialchars($agency['agency_name']); ?></li>
    <li class="list-group-item"><strong>E-posta:</strong> <?php echo htmlspecialchars($agency['email']); ?></li>
    <li class="list-group-item"><strong>Yetkili:</strong> <?php echo htmlspecialchars($agency['contact_name']); ?></li>
    <li class="list-group-item"><strong>Telefon:</strong> <?php echo htmlspecialchars($agency['phone']); ?></li>
    <li class="list-group-item"><strong>Bakiye:</strong> <?php echo number_format($agency['balance'],2); ?> ₺</li>
    <li class="list-group-item"><strong>Durum:</strong> <?php echo htmlspecialchars($agency['status']); ?></li>
</ul>
<h3>Siparişler</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sipariş Adı</th>
            <th>Tutar</th>
            <th>Tarih</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo htmlspecialchars($order['order_name']); ?></td>
            <td><?php echo number_format($order['total'],2); ?> ₺</td>
            <td><?php echo htmlspecialchars($order['created_at']); ?></td>
            <td><a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">Görüntüle</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="agencies.php" class="btn btn-secondary">Geri</a>
<?php include 'partials/footer.php'; ?>
