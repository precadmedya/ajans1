<?php
require_once '../config.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT o.*, a.agency_name, s.title AS service_title FROM orders o JOIN agencies a ON o.agency_id=a.id JOIN services s ON o.service_id=s.id WHERE o.id=?');
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
    <li class="list-group-item"><strong>Hizmet:</strong> <?php echo htmlspecialchars($order['service_title']); ?></li>
    <li class="list-group-item"><strong>Proje Başlığı:</strong> <?php echo htmlspecialchars($order['title']); ?></li>
    <li class="list-group-item"><strong>Açıklama:</strong> <?php echo nl2br(htmlspecialchars($order['description'])); ?></li>
    <li class="list-group-item"><strong>Domain:</strong> <?php echo htmlspecialchars($order['domain']); ?></li>
    <?php if($order['ref_link']): ?><li class="list-group-item"><strong>Referans:</strong> <a href="<?php echo htmlspecialchars($order['ref_link']); ?>" target="_blank">link</a></li><?php endif; ?>
    <?php if($order['file_url']): ?><li class="list-group-item"><strong>Dosya:</strong> <a href="../<?php echo $order['file_url']; ?>" target="_blank">indir</a></li><?php endif; ?>
    <li class="list-group-item"><strong>Tutar:</strong> <?php echo number_format($order['total'],2); ?> ₺</li>
    <li class="list-group-item"><strong>Durum:</strong> <?php echo htmlspecialchars($order['status']); ?></li>
    <li class="list-group-item"><strong>Tarih:</strong> <?php echo htmlspecialchars($order['created_at']); ?></li>
</ul>
<a href="agency_details.php?id=<?php echo $order['agency_id']; ?>" class="btn btn-secondary">Geri</a>
<?php include 'partials/footer.php'; ?>
