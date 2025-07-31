<?php
require_once '../config.php';
if (isset($_SESSION['admin_id'])) {
    header('Location: agency_requests.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = ?');
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: agency_requests.php');
        exit;
    } else {
        $message = 'Geçersiz giriş.';
    }
}
?>
<?php include 'partials/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <h2 class="mb-4 text-center text-white">Admin Girişi</h2>
        <?php if ($message): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label text-white">E-posta</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Şifre</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Giriş</button>
        </form>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
