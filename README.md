# Ajans Giriş Sistemi

Bu proje, Yazılım Ustası sistemine ajansların kayıt olup yönetici onayıyla giriş yapabilmesi için oluşturulmuş basit bir PHP uygulamasıdır.

## Kurulum

1. `config.php` içindeki veritabanı ayarlarını düzenleyin.
2. `database.sql` dosyasını veritabanınıza aktararak gerekli tabloları ve örnek kayıtları oluşturun.
3. `uploads/logos` klasörünün yazılabilir olduğundan emin olun.
4. `index.php` üzerinden giriş yapabilir veya `register.php` ile yeni ajans hesabı oluşturabilirsiniz.
5. Yönetici girişi için `admin/login.php` sayfasını kullanın.

### Örnek Hesaplar

- Yönetici: `admin@example.com` / `admin123`
- Ajans: `demo@agency.com` / `agency123`

Logo ve boyut ayarlarını değiştirmek için yönetici panelindeki `Ayarlar` sayfasını kullanabilirsiniz.
