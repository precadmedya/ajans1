<?php
require_once '../config.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$agency = $pdo->prepare('SELECT * FROM agencies WHERE id = ?');
$agency->execute([$id]);
$agency = $agency->fetch();
if (!$agency) {
    echo 'Ajans bulunamadı';
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('UPDATE agencies SET agency_name=?, contact_name=?, phone=?, email=?, tax_number=?, tax_office=?, balance=? WHERE id=?');
    $stmt->execute([
        $_POST['agency_name'],
        $_POST['contact_name'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['tax_number'],
        $_POST['tax_office'],
        $_POST['balance'],
        $id
    ]);
    $message = 'Güncellendi';
    $agency = $pdo->prepare('SELECT * FROM agencies WHERE id = ?');
    $agency->execute([$id]);
    $agency = $agency->fetch();
}
?>
<?php include 'partials/header.php'; ?>
<h2>Ajans Düzenle</h2>
<?php if ($message): ?>
    <div class="alert alert-success"><?php echo $message; ?></div>
<?php endif; ?>
<form method="post">
    <div class="mb-3">
        <label class="form-label">Ajans Adı</label>
        <input type="text" name="agency_name" value="<?php echo htmlspecialchars($agency['agency_name']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Yetkili Adı Soyadı</label>
        <input type="text" name="contact_name" value="<?php echo htmlspecialchars($agency['contact_name']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Telefon</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($agency['phone']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">E-posta</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($agency['email']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Vergi Numarası</label>
        <input type="text" name="tax_number" value="<?php echo htmlspecialchars($agency['tax_number']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Vergi Dairesi</label>
        <input type="text" name="tax_office" value="<?php echo htmlspecialchars($agency['tax_office']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Bakiye</label>
        <input type="number" step="0.01" name="balance" value="<?php echo htmlspecialchars($agency['balance']); ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Kaydet</button>
    <a href="agencies.php" class="btn btn-secondary">Geri</a>
</form>
<?php include 'partials/footer.php'; ?>
