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

# XSS
** (Cross Site Scripting Attack)** yani çapraz site betik saldırısı. Bir çok web programlama dillerinde meydana gelen bir betik kod ( *html, javascript* vb... ) saldırısıdır.</br>
HTML kodlarının arasına
istemci tabanlı kod gömülmesi yoluyla kullanıcının tarayıcısında istenen istemci
tabanlı kodun çalıştırılabilmesi olarak tanımlanır.</br>
Reflected,Stored ve Dom olarak üç çeşiti vardır.

**Reflected XSS** :Kullanıcının girilmesi beklenen parametre yerine Javascript kodu
girerek bunu ekrana yansıtması ile tespit edilebilen XSS çeşitidir.
```
<script>alert(1)</script>
```


Eğer engellenmiş **< script >** varsa bunun yerine
```
<SCRIPT>alert(1)</SCRIPT>
<sc<script>ript>alert(1)</sc</script>ript>
```
Bu şekilde kullanarakda erişimi sağlayabiliyoruz. Eğer ** *script* ** tagı tamamen engellenmiş ise bunların yerine aşağıdakı erişimi kullanabiliriz.

```
<svg onload=alert(1)>
```

Eğer site ** *alert* ** izin vermiyosa bunun yerine **prompt** kullanabiliriz.
```
<svg onload=prompt(1)>
```


Genel olarak Reflected *XSS* i tanıyarak bir kaç **bypass** yolunu örneklerle inceledik.
Bir çok XSS payloadı bulunmakta ve türemektedir bunları kendimizde üretebilirz.

[Örnek payload][c40e12ea]

```
<meta http-equiv="refresh" content="0;url=javascript:document.cookie=true;">
<META HTTP-EQUIV="Set-Cookie" Content="USERID=<SCRIPT>document.cookie=true</SCRIPT>">
<SCRIPT>document.cookie=true;</SCRIPT>
<IMG SRC="jav ascript:document.cookie=true;">
<IMG SRC="javascript:document.cookie=true;">
<IMG SRC="  javascript:document.cookie=true;">
<BODY onload!#$%&()*~+-_.,:;?@[/|\]^`=document.cookie=true;>
<SCRIPT>document.cookie=true;//<</SCRIPT>
<SCRIPT <B>document.cookie=true;</SCRIPT>
<IMG SRC="javascript:document.cookie=true;">
<iframe src="javascript:document.cookie=true;>
<SCRIPT>a=/CrossSiteScripting/\ndocument.cookie=true;</SCRIPT>
</TITLE><SCRIPT>document.cookie=true;</SCRIPT>
```

[c40e12ea]: https://packetstormsecurity.com/files/112152/Cross-Site-Scripting-Payloads.html "Örnek payload"

**Stored/Persistent XSS:**
Adında anlaşılacağı üzere kalıcı XSS türüdür.Bu sefer girilen **payloadlar** anlık
olarak yansımaz bir veritabanına yada başka bir yere kayıt edilir daha sonradan
ziyaret edildiğinde çalışan XSS çeşitidir.
Reflected XSS e göre daha tehlikelidir etkilenen nokta bir ziyaretçi defteri,duyuru
sayfası gibi bir yer olduğunda sitede o sayfayı ziyaret eden herkesin etkilenmesini
sağlayabilir.
Şöyleki bir kayit ekleyip sonrasinda onu sayfada belli kısımlara aktaracağız eğer bunun önlemini almaz isek bu script kayıt olacaktir ve her sayfa yüklendiği zaman çalışacaktır.


**DOM XSS:**
XSS Dom *( Document Object Model )* lardan kaynaklanan XSS dir.Genelde ``#`` işaretinden sonra payload denenmesi ve sayfa yenilendiğinde alert
alındığında DOM XSS var denilen XSS açıklığıdır.
İşin teorik bilgisi DOM nesnesinden kaynaklandığı için en tehlikeli XSS türü olarak
anılmaktadır.


## Alinacak Önlemler

Kullanmakta oldugumuz tarayıcılar güvenlik açısından bu gibi *client* tarafında çalışan script komutlarına karşı önlemler alıyorlar. **Chrome** alert mesajlarına engelliyor. Bazi tarayicilar url kısmında bu gibi scripleri engellicek alt yapı oluşturuyorlar.
Bizde geliştiriciler olarak girdileri kontrol ederek bunları engelleye biliriz.</br>
###### Reflected XSS
Öncelikle Yüksek seviyeye göre bunları nasıl çözdüğümüzü açıklayalım. **php** betik dilinin hazir fonksiyonu ``htmlspecialchars`` html kodunu çözümler. Verilen parametreyi ** *String* **  yapar. ``str_replace`` bu fonksiyon orta düzey güvenlik için kabul edilebilir. 3 parametre alır bu parametreler: ilk parametre aranan kelime ikinci parametre aranan kelimenin yerine gelicek ifade üçüncü parametre ise girdi olarak verilir ve içerisinde olmamasını istediğimiz kelimeleri çıkartır.Düşük seviye yani güvenlik önlemi alınmadan yazilan kodlarda ne girdisi gelirse onu yorumlar ve sorunlara neden olabilir.
###### Stored XSS
Kalıcı XSS olarak adlandırmıştık yukarıda burada alınması gereken önlemler seviye seviye ayıracağız. Yüksek koruma sağlıyorsak **PHP** 3tane fonksiyonun herbirinden geçirerek veritabanına ekleme yapacağız. Ilk olarak ``stripslashes`` kullanıcağız bu bize **\** işaretini temizlemek için kullanılıyor.
``mysql_real_escape_string`` veritabanına eklemek için stringleri uygun biçime dönüştürür. Son olarakta yukarıda açıkladığımız ``htmlspecialchars`` kullanacağız bu şekilde yüksek olanda koruma sağlıyoruz.``strip_tags`` bu fonksiyon bize html karakterleri temizlememize yarıyor dilersek ikinci parametre olarak gözardı edilebilecek karakterleri girebiliriz. ``addslashes `` bu fonksiyonda **tek tırnak** sorununu çözüyor veritabanına ekleme sırasında söz diziminde tek tırnak var ise bunun başına {**\**} koyarak hata döndürmesinin önüne geçilir. Buda bize zararlı kodlardan sakınmamıza yarıyor. Login gibi işlemlerde yada kayıt sistemlerinde ``trim`` gibi yardımcı fonksiyonlarda kullanılabilir.
