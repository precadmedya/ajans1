<?php
require 'config.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = ?');
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: admin/index.php');
        exit;
    }

    $stmt = $pdo->prepare('SELECT * FROM agencies WHERE email = ? AND status = "active"');
    $stmt->execute([$email]);
    $agency = $stmt->fetch();
    if ($agency && password_verify($password, $agency['password_hash'])) {
        $_SESSION['agency_id'] = $agency['id'];
        header('Location: dashboard.php');
        exit;
    }

    $message = 'Geçersiz giriş bilgileri veya hesap onay bekliyor.';
}
?>
<?php include 'partials/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm p-4">
            <h2 class="mb-4 text-center">Giriş</h2>
            <?php if ($message): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">E-posta</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Şifre</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Giriş</button>
            </form>
            <div class="mt-3 text-center">
                <a href="register.php">Hesabınız yok mu? Kayıt olun</a>
            </div>
        </div>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
