<?php
require 'config.php';
if(!isset($_SESSION['agency_id'])){
    header('Location: index.php');
    exit;
}
$stmt=$pdo->prepare('SELECT o.*, s.title AS service_title FROM orders o JOIN services s ON o.service_id=s.id WHERE o.agency_id=? ORDER BY o.created_at DESC');
$stmt->execute([$_SESSION['agency_id']]);
$orders=$stmt->fetchAll();
?>
<?php include 'partials/header.php'; ?>
<h2>Siparişlerim</h2>
<table class="table table-striped table-bordered table-responsive">
    <thead>
        <tr>
            <th>Proje</th>
            <th>Hizmet</th>
            <th>Tarih</th>
            <th>Tutar</th>
            <th>Durum</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orders as $o): ?>
        <tr>
            <td><?php echo htmlspecialchars($o['title']); ?></td>
            <td><?php echo htmlspecialchars($o['service_title']); ?></td>
            <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($o['created_at']))); ?></td>
            <td><?php echo number_format($o['total'],2); ?> ₺</td>
            <td><?php echo htmlspecialchars($o['status']); ?></td>
            <td><a href="order_details.php?id=<?php echo $o['id']; ?>" class="btn btn-sm btn-outline-primary">Detayları Gör</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'partials/footer.php'; ?>
