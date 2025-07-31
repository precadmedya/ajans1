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
        $stmt->execute([$id]);
    } elseif ($_POST['action'] === 'reject') {
        $stmt = $pdo->prepare('UPDATE agencies SET status = "rejected" WHERE id = ?');
        $stmt->execute([$id]);
    }
}

$agencies = $pdo->query('SELECT * FROM agencies ORDER BY created_at DESC')->fetchAll();
?>
<?php include 'partials/header.php'; ?>
<h2>Ajanslar</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Ajans Adı</th>
            <th>E-posta</th>
            <th>Yetkili</th>
            <th>Telefon</th>
            <th>Bakiye</th>
            <th>Durum</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($agencies as $agency): ?>
        <tr>
            <td><?php echo htmlspecialchars($agency['agency_name']); ?></td>
            <td><?php echo htmlspecialchars($agency['email']); ?></td>
            <td><?php echo htmlspecialchars($agency['contact_name']); ?></td>
            <td><?php echo htmlspecialchars($agency['phone']); ?></td>
            <td><?php echo number_format($agency['balance'],2); ?> ₺</td>
            <td><?php echo htmlspecialchars($agency['status']); ?></td>
            <td>
                <?php if ($agency['status'] === 'pending'): ?>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="id" value="<?php echo $agency['id']; ?>">
                        <input type="hidden" name="action" value="approve">
                        <button class="btn btn-success btn-sm">Onayla</button>
                    </form>
                <?php endif; ?>
                <a href="edit_agency.php?id=<?php echo $agency['id']; ?>" class="btn btn-primary btn-sm ms-1">Düzenle</a>
                <a href="agency_details.php?id=<?php echo $agency['id']; ?>" class="btn btn-secondary btn-sm ms-1">Detay</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'partials/footer.php'; ?>
