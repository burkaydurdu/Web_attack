# Veritabanı Saldırıları

İngilizce karşılığı ** *database* ** olan Veri tabanı; Birbirleriyle ilişkili olan verilerin birlikte tutulduğu yönetilebilir, güncellenebilir, taşınabilir ve anlamlandırılabilir kullanım amacına uygun olarak sistemli bir şekilde toplanmış düzenli bilgiler topluluğudur.</br>
Veri tabanı içerisinde veriler tutulmaktadır peki ya veri nedir?
Veri; İngilizce karşılı ** *datum* ** 'dur. Dağınık bilgi kümesidir. Veri anlamlı bir şekilde düzenlendiği zaman yararlı bilgi olur.

**Sql** en tehlikeli web açıklarındandır.Direk veritabanına erişim sağlandığı için veriler
çalınabilir,silinebilir,değiştirebilir.
Tablo ismlerine, veritabanı ismine kolon
sayılarına,versiyon bilgisine,username password bilgilerine vb bir çok bilgiye
ulaşabilirsiniz.
Bu açığın bulunduğunu bildiğiniz sistemlerde ``Sqlmap`` aracı ile bir çok işlemi
otomize olarak gerçekleştirebilirsiniz.

Veritabanı saldırıları genelde  kullanıcı sistem girişi sağlamasında veritabanı erişimi belirli düzenlemelerle girişin illagel yolla sağlanmasıdır. Yani sql sorgusuna dışarıdan müdehale ile kullancıcının sisteme girmesine olanak verir. Peki bunlar nasıl sağlanır ve bu açıklar nasıl düzenlenir. Öncelikle sql erişimi gibi uzak sunucudaki veriler. Sunucu üzerinde'de çalısan programlar ile yönetilir. Ben burada ** PHP ** kullanacağım. Php de sql sorgusu ile login yapmak istersek aşağıdaki kodu kullanmamız gerekecektir.

```
  $query = "Select *from Students where no = '$no' and password = '$password'";
```

Bu kod'da görülen sorgu klasik ``SELECT`` sorgusudur. kullanıcıdan aldıgı bilgiler ile dogruluk testi yapar ve true döner ise yani aranan kayıt bulunursa sisteme giriş yapılır. Bu kod ve bu login sistemi kırılması kaçınılmazdır. Buradaki sorunlardan bir taneside şifre kısmının düz bir şekilde kayıt edilmesi bu konuya ayriyetten değineceğiz. Peki nasıl kırılır.

``WHERE`` komutundan sonra iki tane boolean işlem yapılır, aralarında ``and`` işlemi sayesiyle iki bool ifadeninde true dönmesi şartıyla işlem bize kayıt döndürür *(aranan kayıt bulunur)*.
## Saldırı


Yukarida görülen erişim bize true döndürecektir ve sisteme sızabiliriz. Peki bu nasıl oluyor. ** password ** kısmını görelim diye görünür yaptım. Burada  yukarıda belirtilen sorguda ilk input kısmı ``no`` alıyor ikinciside ``password`` alıyor. sorgudada görüleceği gibi **'$no'** atanan değer ``'or '1'='1`` dediğimizde ilk no sorgusu yanlış dönse bile eklediğimiz ``or`` ile ``1=1`` eşitliği ile kesinlikle true döner. Bunu her iki kısma uyguladığımızda `` 1.kısım and  2.kısım``  burda her iki kısım da ``true`` olacağı için giriş sağlanacaktır. Tabi burada bilmemiz gereken sql sorgusunda tek tırnak mı yoksa çift tırnak mı kullanıldı bunu deneyerek tespit edebiliriz.

Veritabanından sorgu yapıyorsak diyelim ki numaraya göre arama yapalım burada login gibi `` "...WHERE no = '$no'";" `` diye sorgu var burada  yaptığımız yöntemle ``1' or '1'='1`` bununla birlikte tüm kayıtları listeleyebiliyoruz. Kim var kim yok bilgilerine erişebiliyoruz. Daha farklı sorgular ile  bilgi çalınabilir. Bunlar kodun geri nasıl değer döndürür yada ekranda gösterme şekillerine göre değişir yapıdadır. Örnek verirsek ``1' UNION SELECT 1,2 #`` kolon sayısını tespit etme, ``1' UNION SELECT version(),2 #`` veritabanının versiyon bilgisi, ``1' UNION SELECT database(),2 #`` veritabanının isim bilgisi
vb.. bir çok sorgu ile önlemler alınmamış ise bu bilgileri gözlemlememiz kaçınılmazdır.
## Alınacak Önlemler
Alınacak önlemler kısmında **xss** kısmındada belirttiğimiz gibi **php** betik dilinde bulunan hazir fonksiyonları kullanabiliriz, internette güvenlik için yazilan fonksiyonları projemize katabiliriz yada kendimiz bir fonksiyon yazip denetleme yapabiliriz. Girdiler neyi istiyorsa ona göre söz dizimleri hazirlayabilir ve denetleyebiliriz.No istiyorsa sadece sayi değerlerinde oluşan bir girdi için denetim yapabiliriz.login kisminda özel karakterleri kontrol edip varsa girdiyi geçersiz kılabiliriz.
