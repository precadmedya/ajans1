<?php
require_once '../config.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['action'], $_POST['id'])) {
    $id = (int)$_POST['id'];
    if ($_POST['action'] === 'approve') {
        $stmt = $pdo->prepare('UPDATE agencies SET status = "active" WHERE id = ?');
    } else {
        $stmt = $pdo->prepare('UPDATE agencies SET status = "rejected" WHERE id = ?');
    }
    $stmt->execute([$id]);
}

$pending = $pdo->query("SELECT * FROM agencies WHERE status = 'pending'")->fetchAll();
?>
<?php include 'partials/header.php'; ?>
<h2>Bekleyen Ajans Kayıtları</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Ajans Adı</th>
            <th>Yetkili</th>
            <th>E-posta</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pending as $agency): ?>
            <tr>
                <td><?php echo htmlspecialchars($agency['agency_name']); ?></td>
                <td><?php echo htmlspecialchars($agency['contact_name']); ?></td>
                <td><?php echo htmlspecialchars($agency['email']); ?></td>
                <td>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="id" value="<?php echo $agency['id']; ?>">
                        <input type="hidden" name="action" value="approve">
                        <button class="btn btn-success btn-sm">Onayla</button>
                    </form>
                    <form method="post" class="d-inline ms-2">
                        <input type="hidden" name="id" value="<?php echo $agency['id']; ?>">
                        <input type="hidden" name="action" value="reject">
                        <button class="btn btn-danger btn-sm">Reddet</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'partials/footer.php'; ?>
