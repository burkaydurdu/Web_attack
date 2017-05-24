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
