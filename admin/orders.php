<?php
require_once '../config.php';
if(!isset($_SESSION['admin_id'])){
    header('Location: login.php');
    exit;
}
if(isset($_POST['action'],$_POST['id'])){
    $id=(int)$_POST['id'];
    $stmt=$pdo->prepare('SELECT * FROM orders WHERE id=?');
    $stmt->execute([$id]);
    $order=$stmt->fetch();
    if($order){
        if($_POST['action']==='approve'){
            $pdo->prepare('UPDATE orders SET status="approved" WHERE id=?')->execute([$id]);
            // deduct balance
            $pdo->prepare('UPDATE agencies SET balance=balance-?, debt=IF(balance-? < 0, debt + ABS(balance-?), debt) WHERE id=?')
                ->execute([$order['total'],$order['total'],$order['total'], $order['agency_id']]);
        }elseif($_POST['action']==='reject'){
            $pdo->prepare('UPDATE orders SET status="rejected" WHERE id=?')->execute([$id]);
        }
    }
}
$orders=$pdo->query('SELECT o.*, a.agency_name, s.title AS service_title FROM orders o JOIN agencies a ON o.agency_id=a.id JOIN services s ON o.service_id=s.id ORDER BY o.created_at DESC')->fetchAll();
?>
<?php include 'partials/header.php'; ?>
<h2>Siparişler</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Ajans</th>
            <th>Hizmet</th>
            <th>Proje</th>
            <th>Tutar</th>
            <th>Durum</th>
            <th>İşlem</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orders as $o): ?>
        <tr>
            <td><?php echo htmlspecialchars($o['agency_name']); ?></td>
            <td><?php echo htmlspecialchars($o['service_title']); ?></td>
            <td><?php echo htmlspecialchars($o['title']); ?></td>
            <td><?php echo number_format($o['total'],2); ?> ₺</td>
            <td><?php echo htmlspecialchars($o['status']); ?></td>
            <td>
                <?php if($o['status']==='pending'): ?>
                <form method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?php echo $o['id']; ?>">
                    <input type="hidden" name="action" value="approve">
                    <button class="btn btn-sm btn-success">Onayla</button>
                </form>
                <form method="post" class="d-inline ms-2">
                    <input type="hidden" name="id" value="<?php echo $o['id']; ?>">
                    <input type="hidden" name="action" value="reject">
                    <button class="btn btn-sm btn-danger">Reddet</button>
                </form>
                <?php endif; ?>
                <a href="order_details.php?id=<?php echo $o['id']; ?>" class="btn btn-sm btn-outline-primary ms-1">Detay</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'partials/footer.php'; ?>
