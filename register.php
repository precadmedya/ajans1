<?php
require 'config.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $agency_name = $_POST['agency_name'];
    $contact_name = $_POST['contact_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tax_number = $_POST['tax_number'];
    $tax_office = $_POST['tax_office'];
    $logoPath = null;

    if (!empty($_FILES['logo']['name'])) {
        $targetDir = 'uploads/logos/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = uniqid() . '_' . basename($_FILES['logo']['name']);
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
            $logoPath = $targetFile;
        }
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO agencies (agency_name, contact_name, phone, email, password_hash, tax_number, tax_office, logo_url, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, "pending")');
    $stmt->execute([$agency_name, $contact_name, $phone, $email, $hash, $tax_number, $tax_office, $logoPath]);
    $message = 'Kaydınız alınmıştır, yönetici onayından sonra giriş yapabilirsiniz.';
}
?>
<?php include 'partials/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card shadow-sm p-4">
            <h2 class="mb-4 text-center">Ajans Kaydı</h2>
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Ajans Adı</label>
                    <input type="text" name="agency_name" class="form-control" required>
                </div>
            <div class="mb-3">
                <label class="form-label">Yetkili Adı Soyadı</label>
                <input type="text" name="contact_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Telefon</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">E-posta</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Şifre</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Vergi Numarası</label>
                <input type="text" name="tax_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Vergi Dairesi</label>
                <input type="text" name="tax_office" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ajans Logosu</label>
                <input type="file" name="logo" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Kaydol</button>
        </form>
        </div>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
