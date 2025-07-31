<?php
require_once '../config.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$settings = $pdo->query('SELECT * FROM settings LIMIT 1')->fetch();
if (!$settings) {
    $settings = [
        'id' => 0,
        'logo_url' => null,
        'logo_width' => 40,
        'logo_height' => 40,
        'header_bg' => '#343a40',
        'header_color' => '#ffffff'
    ];
}
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logo_width = (int)$_POST['logo_width'];
    $logo_height = (int)$_POST['logo_height'];
    $header_bg = $_POST['header_bg'];
    $header_color = $_POST['header_color'];
    $logo_path = $settings['logo_url'];

    if (!empty($_FILES['logo']['name'])) {
        $targetDir = '../uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = uniqid() . '_' . basename($_FILES['logo']['name']);
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
            $logo_path = 'uploads/' . $fileName;
        }
    }

    $stmt = $pdo->prepare('UPDATE settings SET logo_url = ?, logo_width = ?, logo_height = ?, header_bg=?, header_color=? WHERE id = ?');
    $stmt->execute([$logo_path, $logo_width, $logo_height, $header_bg, $header_color, $settings['id']]);
    $message = 'Ayarlar güncellendi';
    $settings = [
        'id'=>$settings['id'],
        'logo_url'=>$logo_path,
        'logo_width'=>$logo_width,
        'logo_height'=>$logo_height,
        'header_bg'=>$header_bg,
        'header_color'=>$header_color
    ];
}
?>
<?php include 'partials/header.php'; ?>
<h2>Ayarlar</h2>
<?php if ($message): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data" class="mb-4">
    <div class="mb-3">
        <label class="form-label">Logo</label>
        <input type="file" name="logo" class="form-control">
        <?php if ($settings && $settings['logo_url']): ?>
            <img src="../<?php echo $settings['logo_url']; ?>" alt="Logo" class="mt-2" style="max-height:50px;">
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Genişlik (px)</label>
        <input type="number" name="logo_width" value="<?php echo $settings['logo_width']; ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Yükseklik (px)</label>
        <input type="number" name="logo_height" value="<?php echo $settings['logo_height']; ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Header Arkaplan Rengi</label>
        <input type="color" name="header_bg" value="<?php echo $settings['header_bg']; ?>" class="form-control form-control-color" />
    </div>
    <div class="mb-3">
        <label class="form-label">Header Yazı Rengi</label>
        <input type="color" name="header_color" value="<?php echo $settings['header_color']; ?>" class="form-control form-control-color" />
    </div>
    <button type="submit" class="btn btn-primary">Kaydet</button>
</form>
<?php include 'partials/footer.php'; ?>
