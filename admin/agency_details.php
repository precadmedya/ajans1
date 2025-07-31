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

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'])) {
    $amount = (float)$_POST['amount'];
    $stmt = $pdo->prepare('UPDATE agencies SET balance = balance + ? WHERE id=?');
    $stmt->execute([$amount, $id]);
    $message = 'Bakiye güncellendi';
    $agencyStmt->execute([$id]);
    $agency = $agencyStmt->fetch();
}

$orders = $pdo->prepare('SELECT o.*, s.title AS service_title FROM orders o JOIN services s ON o.service_id=s.id WHERE o.agency_id=? ORDER BY o.created_at DESC');
$orders->execute([$id]);
$orders = $orders->fetchAll();
?>
<?php include 'partials/header.php'; ?>
<h2>Ajans Detayları</h2>
<?php if ($message): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>
<ul class="list-group mb-4">
    <li class="list-group-item"><strong>Ajans:</strong> <?php echo htmlspecialchars($agency['agency_name']); ?></li>
    <li class="list-group-item"><strong>E-posta:</strong> <?php echo htmlspecialchars($agency['email']); ?></li>
    <li class="list-group-item"><strong>Yetkili:</strong> <?php echo htmlspecialchars($agency['contact_name']); ?></li>
    <li class="list-group-item"><strong>Telefon:</strong> <?php echo htmlspecialchars($agency['phone']); ?></li>
    <li class="list-group-item"><strong>Bakiye:</strong> <?php echo number_format($agency['balance'],2); ?> ₺</li>
    <li class="list-group-item"><strong>Borç:</strong> <?php echo number_format($agency['debt'],2); ?> ₺</li>
    <li class="list-group-item"><strong>Durum:</strong> <?php echo htmlspecialchars($agency['status']); ?></li>
</ul>
<form method="post" class="mb-4">
    <label class="form-label">Tahsilat Tutarı</label>
    <div class="input-group">
        <input type="number" step="0.01" name="amount" class="form-control" required>
        <button class="btn btn-success" type="submit">Tahsilat Yap</button>
    </div>
</form>
<h3>Siparişler</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Hizmet</th>
            <th>Proje</th>
            <th>Tutar</th>
            <th>Durum</th>
            <th>Tarih</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo htmlspecialchars($order['service_title']); ?></td>
            <td><?php echo htmlspecialchars($order['title']); ?></td>
            <td><?php echo number_format($order['total'],2); ?> ₺</td>
            <td><?php echo htmlspecialchars($order['status']); ?></td>
            <td><?php echo htmlspecialchars($order['created_at']); ?></td>
            <td><a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">Görüntüle</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="agencies.php" class="btn btn-secondary">Geri</a>
<?php include 'partials/footer.php'; ?>
