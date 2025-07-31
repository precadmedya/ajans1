<?php
require 'config.php';
if(!isset($_SESSION['agency_id'])){
    header('Location: index.php');
    exit;
}
$services = $pdo->query('SELECT * FROM services ORDER BY title')->fetchAll();
$message='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $serviceId=(int)$_POST['service_id'];
    $title=$_POST['title'];
    $description=$_POST['description'];
    $domain=$_POST['domain'];
    $ref_link=$_POST['ref_link'] ?: null;
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
    $service=$pdo->prepare('SELECT * FROM services WHERE id=?');
    $service->execute([$serviceId]);
    $service=$service->fetch();
    if($service){
        $price=$service['unit_price'];
        $vat=$price*$service['vat_rate']/100;
        $total=$price+$vat;
        $stmt=$pdo->prepare('INSERT INTO orders (agency_id,service_id,title,description,domain,ref_link,file_url,price,vat,total,status) VALUES (?,?,?,?,?,?,?,?,?,"pending")');
        $stmt->execute([$_SESSION['agency_id'],$serviceId,$title,$description,$domain,$ref_link,$file_url,$price,$vat,$total]);
        $message='Siparişiniz alınmıştır.';
    }
}
?>
<?php include 'partials/header.php'; ?>
<h2>Sipariş Ver</h2>
<?php if($message): ?>
<div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
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
        <label class="form-label">Referans Link</label>
        <input type="url" name="ref_link" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Dosya Yükleme</label>
        <input type="file" name="file" class="form-control">
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
