<?php
require_once '../config.php';
if(!isset($_SESSION['admin_id'])){
    header('Location: login.php');
    exit;
}
$message='';
// handle delete
if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    $pdo->prepare('DELETE FROM services WHERE id=?')->execute([$id]);
    header('Location: services.php');
    exit;
}
// handle add/update
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title=$_POST['title'];
    $description=$_POST['description'];
    $price=(float)$_POST['unit_price'];
    $vat_rate=(int)$_POST['vat_rate'];
    if(isset($_POST['id']) && $_POST['id']){
        $id=(int)$_POST['id'];
        $stmt=$pdo->prepare('UPDATE services SET title=?, description=?, unit_price=?, vat_rate=? WHERE id=?');
        $stmt->execute([$title,$description,$price,$vat_rate,$id]);
        $message='Güncellendi';
    }else{
        $stmt=$pdo->prepare('INSERT INTO services (title,description,unit_price,vat_rate) VALUES (?,?,?,?)');
        $stmt->execute([$title,$description,$price,$vat_rate]);
        $message='Eklendi';
    }
}
$edit=null;
if(isset($_GET['edit'])){
    $id=(int)$_GET['edit'];
    $stmt=$pdo->prepare('SELECT * FROM services WHERE id=?');
    $stmt->execute([$id]);
    $edit=$stmt->fetch();
}
$services=$pdo->query('SELECT * FROM services ORDER BY id DESC')->fetchAll();
?>
<?php include 'partials/header.php'; ?>
<h2>Hizmetler</h2>
<?php if($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
<form method="post" class="mb-4">
    <input type="hidden" name="id" value="<?php echo $edit['id']??''; ?>">
    <div class="mb-3">
        <label class="form-label">Başlık</label>
        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($edit['title']??''); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Açıklama</label>
        <textarea name="description" class="form-control" rows="2"><?php echo htmlspecialchars($edit['description']??''); ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Birim Fiyat</label>
        <input type="number" step="0.01" name="unit_price" class="form-control" value="<?php echo htmlspecialchars($edit['unit_price']??''); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">KDV Oranı</label>
        <input type="number" name="vat_rate" class="form-control" value="<?php echo htmlspecialchars($edit['vat_rate']??20); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Kaydet</button>
    <?php if($edit): ?><a href="services.php" class="btn btn-secondary ms-2">Vazgeç</a><?php endif; ?>
</form>
<table class="table table-striped">
    <thead>
        <tr><th>Başlık</th><th>Fiyat</th><th>KDV</th><th></th></tr>
    </thead>
    <tbody>
        <?php foreach($services as $s): ?>
        <tr>
            <td><?php echo htmlspecialchars($s['title']); ?></td>
            <td><?php echo number_format($s['unit_price'],2); ?> ₺</td>
            <td>%<?php echo (int)$s['vat_rate']; ?></td>
            <td>
                <a href="services.php?edit=<?php echo $s['id']; ?>" class="btn btn-sm btn-outline-primary">Düzenle</a>
                <a href="services.php?delete=<?php echo $s['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Silinsin mi?');">Sil</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'partials/footer.php'; ?>
