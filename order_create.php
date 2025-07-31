<?php
require 'config.php';
if(!isset($_SESSION['agency_id'])){
    header('Location: index.php');
    exit;
}
$services = $pdo->query('SELECT * FROM services ORDER BY title')->fetchAll();
$message='';
$messageType='success';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $serviceId=(int)$_POST['service_id'];
    $title=trim($_POST['title']);
    $description=trim($_POST['description']);
    $domain=trim($_POST['domain']);
    $publish_date=$_POST['publish_date'] ?: null;
    $ref_link=trim($_POST['ref_link'] ?? '') ?: null;
    $kvkk=isset($_POST['kvkk']);
    $balance_ok=isset($_POST['balance_ok']);
    $file_url=null;
    if(!empty($_FILES['file']['name'])){
        $dir='uploads/orders/';
        if(!is_dir($dir))mkdir($dir,0777,true);
        $filename=uniqid().'_'.basename($_FILES['file']['name']);
        $target=$dir.$filename;
        if(move_uploaded_file($_FILES['file']['tmp_name'],$target)){
            $file_url=$target;
        }
    }
    if(!$kvkk || !$balance_ok || !$serviceId || !$title || !$domain){
        $message='Lütfen tüm zorunlu alanları doldurun ve onay kutularını işaretleyin.';
        $messageType='danger';
    } else {
        $service=$pdo->prepare('SELECT * FROM services WHERE id=?');
        $service->execute([$serviceId]);
        $service=$service->fetch();
        if($service){
            $price=$service['unit_price'];
            $vat=$price*$service['vat_rate']/100;
            $total=$price+$vat;
            $stmt=$pdo->prepare('INSERT INTO orders (agency_id,service_id,title,description,domain,ref_link,file_url,publish_date,price,vat,total,status) VALUES (?,?,?,?,?,?,?,?,?,?,?,"pending")');
            $stmt->execute([$_SESSION['agency_id'],$serviceId,$title,$description,$domain,$ref_link,$file_url,$publish_date,$price,$vat,$total]);
            $message='Siparişiniz alınmıştır.';
            $messageType='success';
        }
    }
}
?>
<?php include 'partials/header.php'; ?>
<h2>Sipariş Ver</h2>
<?php if($message): ?>
<div class="alert alert-<?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data" id="orderForm">
    <div class="mb-3">
        <label class="form-label">Hizmet</label>
        <select name="service_id" class="form-select" required>
            <option value="">Seçiniz</option>
            <?php foreach($services as $s): ?>
                <option value="<?php echo $s['id']; ?>" data-price="<?php echo $s['unit_price']; ?>" data-vat="<?php echo $s['vat_rate']; ?>"><?php echo htmlspecialchars($s['title']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div id="priceInfo" class="mb-3" style="display:none;">
        <p>Birim Fiyat: <span id="unitPrice"></span> ₺</p>
        <p>KDV Tutarı: <span id="vatAmount"></span> ₺</p>
        <p>KDV Dahil Fiyat: <strong id="totalAmount"></strong> ₺</p>
    </div>
    <div class="mb-3">
        <label class="form-label">Proje Başlığı</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Açıklama</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Domain / Yayın Alanı</label>
        <input type="text" name="domain" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Yayın Tarihi</label>
        <input type="date" name="publish_date" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Referans Link</label>
        <input type="url" name="ref_link" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Dosya Yükleme</label>
        <input type="file" name="file" class="form-control">
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="kvkk" id="kvkk" required>
        <label class="form-check-label" for="kvkk">KVKK metnini okudum, kabul ediyorum</label>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="balance_ok" id="balance_ok" required>
        <label class="form-check-label" for="balance_ok">Bakiyemin kullanılmasını onaylıyorum</label>
    </div>
    <button type="submit" class="btn btn-primary">Gönder</button>
</form>
<script>
const serviceSelect=document.querySelector('select[name="service_id"]');
const priceInfo=document.getElementById('priceInfo');
const unitSpan=document.getElementById('unitPrice');
const vatSpan=document.getElementById('vatAmount');
const totalSpan=document.getElementById('totalAmount');
serviceSelect.addEventListener('change',function(){
    const opt=this.options[this.selectedIndex];
    if(!opt.value){priceInfo.style.display='none';return;}
    const price=parseFloat(opt.dataset.price);
    const vatRate=parseFloat(opt.dataset.vat);
    const vat=price*vatRate/100;
    const total=price+vat;
    unitSpan.textContent=price.toFixed(2);
    vatSpan.textContent=vat.toFixed(2);
    totalSpan.textContent=total.toFixed(2);
    priceInfo.style.display='block';
});
</script>
<?php include 'partials/footer.php'; ?>
