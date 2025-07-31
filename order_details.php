<?php
require 'config.php';
if(!isset($_SESSION['agency_id'])){
    header('Location: index.php');
    exit;
}
$id=(int)($_GET['id'] ?? 0);
$stmt=$pdo->prepare('SELECT o.*, s.title AS service_title FROM orders o JOIN services s ON o.service_id=s.id WHERE o.id=? AND o.agency_id=?');
$stmt->execute([$id, $_SESSION['agency_id']]);
$order=$stmt->fetch();
if(!$order){
    echo 'Sipariş bulunamadı';
    exit;
}
?>
<?php include 'partials/header.php'; ?>
<h2>Sipariş Detayı</h2>
<ul class="list-group mb-4">
    <li class="list-group-item"><strong>Hizmet:</strong> <?php echo htmlspecialchars($order['service_title']); ?></li>
    <li class="list-group-item"><strong>Proje:</strong> <?php echo htmlspecialchars($order['title']); ?></li>
    <li class="list-group-item"><strong>Açıklama:</strong> <?php echo nl2br(htmlspecialchars($order['description'])); ?></li>
    <li class="list-group-item"><strong>Domain:</strong> <?php echo htmlspecialchars($order['domain']); ?></li>
    <?php if($order['publish_date']): ?><li class="list-group-item"><strong>Yayın Tarihi:</strong> <?php echo htmlspecialchars($order['publish_date']); ?></li><?php endif; ?>
    <?php if($order['ref_link']): ?><li class="list-group-item"><strong>Referans:</strong> <a href="<?php echo htmlspecialchars($order['ref_link']); ?>" target="_blank">link</a></li><?php endif; ?>
    <?php if($order['file_url']): ?><li class="list-group-item"><strong>Dosya:</strong> <a href="<?php echo $order['file_url']; ?>" target="_blank">indir</a></li><?php endif; ?>
    <li class="list-group-item"><strong>Tutar:</strong> <?php echo number_format($order['total'],2); ?> ₺</li>
    <li class="list-group-item"><strong>Durum:</strong> <?php echo htmlspecialchars($order['status']); ?></li>
</ul>
<div class="progress mb-3" style="height:20px;">
  <div class="progress-bar" role="progressbar" style="width:<?php echo $order['status']==='pending'? '25':'75'; ?>%" aria-valuenow="<?php echo $order['status']==='pending'? '25':'75'; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo htmlspecialchars($order['status']); ?></div>
</div>
<a href="orders.php" class="btn btn-secondary">Geri</a>
<?php include 'partials/footer.php'; ?>
