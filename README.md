# Ajans Giriş Sistemi

Bu proje, Yazılım Ustası sistemine ajansların kayıt olup yönetici onayıyla giriş yapabilmesi için oluşturulmuş basit bir PHP uygulamasıdır.

## Kurulum

1. `config.php` içindeki veritabanı ayarlarını düzenleyin.
2. `database.sql` dosyasını veritabanınıza aktararak gerekli tabloları ve örnek kayıtları oluşturun.
3. `uploads/logos` klasörünün yazılabilir olduğundan emin olun.
4. `index.php` üzerinden hem yönetici hem de ajans girişi yapılabilir. Yeni ajans
   hesabı oluşturmak için `register.php` sayfasını kullanın.
   Yönetici hesapları onay beklemez, veritabanında tanımladığınız bilgilerle
   doğrudan giriş yapabilirsiniz. Ajans kayıtları ise yönetici onayına kadar
   **pending** durumunda kalır ve giriş yapamaz.
5. Admin panelinde anasayfa, ajans listesi ve ayarlar menülerine erişebilirsiniz.
   Hizmet eklemek ve siparişleri onaylamak için yeni "Hizmetler" ve "Siparişler" bölümlerini kullanın.

### Örnek Hesaplar

- Yönetici: `admin@example.com` / `admin123`
- Ajans: `demo@agency.com` / `agency123`

Logo, boyut ve başlık renklerini değiştirmek için yönetici panelindeki `Ayarlar` sayfasını kullanabilirsiniz.
`Ajanslar` menüsünden kayıtlı ajansları yönetebilir ve her ajansa ait siparişleri görüntüleyebilirsiniz. Ajans panelindeki "Sipariş Ver" sayfasından hizmet seçilerek yeni sipariş oluşturulur. Yönetici onay verdiğinde tutar ajans bakiyesinden düşer, bakiye yetersizse borç hanesine yazılır.
