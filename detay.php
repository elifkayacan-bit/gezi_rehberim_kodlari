<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

// Url'den gelen yer bilgisini alıyoruz
$yer_anahtar = isset($_GET['yer']) ? $_GET['yer'] : '';

// Gezi noktalarının detaylı veri havuzu
$gezi_noktalari = [
    'karanlik_kanyon' => [
        'baslik' => 'Karanlık Kanyon',
        'konum' => 'Erzincan / Kemaliye',
        'puan' => '4.8',
       'gorsel' => 'images/karanlik_kanyon.jpg',
        'aciklama' => 'Erzincan’ın Kemaliye ilçesinde yer alan Karanlık Kanyon, dünyanın en büyük kanyonları arasında gösterilmektedir. Fırat Nehri’nin binlerce yılda dağları delerek oluşturduğu bu muazzam doğa harikası, yer yer 500-600 metreyi bulan dik uçurum duvarlarıyla büyüleyici bir derinliğe sahiptir.',
        'neler_yapilir' => 'Kanyonda düzenlenen meşhur tekne ve bot turlarına katılarak devasa kayalıkların arasından süzülebilirsiniz. Ayrıca kanyon boyunca uzanan, insan eliyle oyulmuş dünyanın en tehlikeli yollarından biri sayılan tarihi "Taş Yol" rotasında doğa yürüyüşü ve safari yapabilirsiniz. Adrenalin tutkunları için kanyonda Base Jumping (serbest atlayış) etkinlikleri de düzenlenmektedir.',
        'nasil_gidilir' => 'Erzincan merkezden Kemaliye ilçesine giden otobüs veya minibüsleri kullanabilirsiniz. Özel aracınızla gidecekseniz Erzincan-Sivas yolu üzerinden Kemaliye tabelalarını takip ederek muhteşem manzaralı dağ yollarından kanyona ulaşabilirsiniz.'
    ],
    'cehennem_deresi' => [
        'baslik' => 'Cehennem Deresi Kanyonu',
        'konum' => 'Artvin / Ardanuç',
        'puan' => '4.7',
        'gorsel' => 'images/cehennem_deresi.jpg',
        'aciklama' => 'Artvin ilinin Ardanuç ilçesinde bulunan Cehennem Deresi Kanyonu, dik duvarları ve el değmemiş doğası ile Türkiye’nin en gizemli kanyonlarından biridir. Girişi oldukça dar olan ve içeri doğru ilerledikçe genişleyen bu kanyon, gökyüzünü neredeyse kapatan devasa kaya bloklarıyla mistik bir atmosfer sunar.',
        'neler_yapilir' => 'Kanyonun dar patikalarında doğa yürüyüşleri (trekking) yapabilir, vahşi hayatı ve kanyonun katmanlı jeolojik yapısını fotoğraflayabilirsiniz. Kanyonun sessizliği ve doğallığı içinde kamp kurmak doğaseverler için eşsiz bir deneyimdir.',
        'nasil_gidilir' => 'Artvin merkezden Ardanuç ilçesine ulaşım sağladıktan sonra, ilçenin yaklaşık 20 km uzağında bulunan kanyon bölgesine tabelaları takip ederek özel aracınızla veya ilçe merkezinden kalkan turlarla rahatlıkla varabilirsiniz.'
    ],
    'frig_vadisi' => [
        'baslik' => 'Frig Vadisi ve Midas Anıtı',
        'konum' => 'Eskişehir / Afyon',
        'puan' => '4.9',
'gorsel' => 'images/44.jpg',
        'aciklama' => 'Eskişehir, Afyonkarahisar ve Kütahya illeri arasında kalan Frig Vadisi, antik Frig medeniyetinin izlerini günümüze taşıyan devasa bir açık hava müzesidir. Bölgedeki tüf kayaların aşınmasıyla oluşan kaya yapıları buraya küçük bir Kapadokya havası katmaktadır. Vadinin en görkemli yapısı ise kaya üzerine işlenmiş Midas Anıtı (Yazılıkaya) olarak bilinir.',
        'neler_yapilir' => 'Binlerce yıllık kaya mezarlarını, kiliseleri ve antik yerleşim kalıntılarını yürüyerek veya bisiklet kiralayarak keşfedebilirsiniz. Son yıllarda vadide Kapadokya’daki gibi sıcak hava balonu uçuşları da başlamıştır.',
        'nasil_gidilir' => 'Eskişehir merkezinden Yazılıkaya / Han yönüne giden araçlarla veya özel aracınızla Seyitgazi ilçesi üzerinden tabelaları takip ederek tarihi vadi bölgesine konforlu bir şekilde ulaşabilirsiniz.'
    ],
    'kaklik_magarasi' => [
        'baslik' => 'Kaklık Mağarası (Yeraltı Pamukkalesi)',
        'konum' => 'Denizli',
        'puan' => '4.8',
        'gorsel' => 'images/kaklik_magrasi.jpg',
        'aciklama' => 'Denizli’nin Honaz ilçesinde yer alan Kaklık Mağarası, kelimenin tam anlamıyla Pamukkale Travertenleri’nin yer altındaki gizli bir versiyonudur. Mağaranın tavanının çökmesiyle oluşan bu yeraltı cenneti, içerisindeki termal suların oluşturduğu bembeyaz traverten basamakları ve sarkıtlarıyla ziyaretçilerini şaşkına çevirir.',
        'neler_yapilir' => 'Ahşap yürüyüş yolları üzerinden mağaranın derinliklerine inebilir, şifalı kükürtlü suların akışını izleyebilir ve yer altı travertenlerinin eşsiz görselliğini fotoğraflayabilirsiniz. Mağara suyunun cilde ve göz hastalıklarına iyi geldiği bilinmektedir.',
        'nasil_gidilir' => 'Denizli-Afyon karayolu üzerinde, Denizli merkeze yaklaşık 30 km mesafededir. Ana yoldan Kaklık Mağarası sapağına dönerek 2-3 dakika içinde özel aracınızla veya Honaz minibüsleriyle ulaşabilirsiniz.'
    ],
    'gideros_koyu' => [
        'baslik' => 'Gideros Koyu',
        'konum' => 'Kastamonu / Cide',
        'puan' => '4.9',
       'gorsel' => 'images/gideros_koyu.jpg',
        'aciklama' => 'Kastamonu’nun Cide ilçesinde bulunan Gideros Koyu, Karadeniz’in vahşi ve dalgalı sularından saklanmış, göl kadar durgun yeşil bir vhadır. Antik çağlarda Homeros’un İlyada destanında bile adı geçen bu koy, kestane, meşe ve çam ağaçlarının denizle kucaklaştığı saklı bir Karadeniz cennetidir.',
        'neler_yapilir' => 'Koyda bulunan küçük kayıklarla deniz turuna çıkabilir, yemyeşil doğanın gölgesinde yüzebilirsiniz. Koy kenarındaki yerel balık restoranlarında Karadeniz’in taze balıklarının tadına bakabilir, doğa içinde sakin kamplar yapabilirsiniz.',
        'nasil_gidilir' => 'Cide ilçe merkezine 11 km mesafede yer alır. Kastamonu ile Bartın arasındaki sahil yolunu (Karadeniz Sahil Yolu) takip ederek Gideros Koyu’na özel aracınız veya Cide otobüsleri ile kolayca ulaşabilirsiniz.'
    ],
    'blaundus' => [
        'baslik' => 'Blaundus Antik Kenti',
        'konum' => 'Uşak',
        'puan' => '4.6',
       'gorsel' => 'images/blaundos.jpg',
        'aciklama' => 'Uşak ilinin Ulubey ilçesinde bulunan Blaundus Antik Kenti, Büyük İskender’in Anadolu seferinden sonra Makedonyalılar tarafından kurulmuştur. Üç tarafı derin ve uçurumlu Ulubey Kanyonu ile çevrili bir yarımada üzerinde yer alan kent, stratejik konumu ve günümüze kadar ulaşan devasa taş kapılarıyla dikkat çeker.',
        'neler_yapilir' => 'Antik kentin ayakta kalan stadyum, tapınak ve kaya mezarları kalıntılarını gezebilirsiniz. Özellikle astrofotoğrafçılık (yıldız pozlama) ile ilgilenenler için Blaundus, ışık kirliliğinin az olması sebebiyle geceleri muazzam gökyüzü manzaraları sunar.',
        'nasil_gidilir' => 'Uşak il merkezine yaklaşık 40 km uzaklıktadır. Ulubey ilçesine geldikten sonra Sülümenli köyü yönündeki tabelaları takip ederek özel aracınızla antik kentin o etkileyici giriş kapısına ulaşabilirsiniz.'
    ],
'giethoorn' => [
        'baslik' => 'Giethoorn',
        'konum' => 'Hollanda',
        'puan' => '4.9',
       'gorsel' => 'images/giethoorn.jpg',
        'aciklama' => 'Hiç araba yolunun olmadığı, ulaşımın tamamen kanallarda sandallarla veya ahşap köprülerden yürüyerek sağlandığı masal köyü. Huzurun ve doğanın eşsiz uyumunu burada bulabilirsiniz.',
        'neler_yapilir' => 'Kanallarda elektrikli fısıltı tekneleriyle tur yapabilir, tarihi ahşap köprülerde yürüyebilir ve göl kenarındaki kafelerde vakit geçirebilirsiniz.',
        'nasil_gidilir' => 'Amsterdam merkezinden trenle Steenwijk istasyonuna ulaştıktan sonra 70 numaralı otobüslere binerek köye doğrudan ulaşım sağlayabilirsiniz.'
    ],
    'bled_golu' => [
        'baslik' => 'Bled Gölü',
        'konum' => 'Slovenya',
        'puan' => '5.0',
        'gorsel' => 'images/blend.jpg',
        'aciklama' => 'Alp Dağları\'nın eteğinde, gölün tam ortasındaki mini adada yer alan kilisesiyle dünyadan soyutlanmış gibi duran huzur rotası. Ziyaretçilerine büyüleyici bir atmosfer sunar.',
        'neler_yapilir' => 'Geleneksel Pletna tekneleriyle adaya çıkabilir, Bled Kalesi\'nden göl manzarasını izleyebilir ve meşhur Bled krem şantili pastasını (Kremšnita) tadabilirsiniz.',
        'nasil_gidilir' => 'Başkent Ljubljana otogarından saat başı kalkan otobüslerle yaklaşık 1 saatlik keyifli bir yolculuk sonrası göle doğrudan varabilirsiniz.'
    ],
    'hallstatt' => [
        'baslik' => 'Hallstatt Kasabası',
        'konum' => 'Avusturya',
        'puan' => '4.8',
       'gorsel' => 'images/hallstat.jpg',
        'aciklama' => 'Bir dağın yamacına dizilmiş tarihi ahşap evleri ve nefes kesen göl manzarasıyla dünyanın en güzel korunan ve en estetik göl kenarı kasabalarından biridir.',
        'neler_yapilir' => 'Dünyanın en eski tuz madenini (Salzwelten) ziyaret edebilir, Skywalk seyir terasından manzarayı izleyebilir ve dar sokaklarında fotoğraf turuna çıkabilirsiniz.',
        'nasil_gidilir' => 'Salzburg şehrinden otobüs veya tren aktarmalarıyla ya da gölün karşı kıyısından kalkan feribotlar aracılığıyla kasabaya ulaşabilirsiniz.'
    ],
    
    

];


// Eğer geçersiz bir yer seçildiyse veya bulunamadıysa ilk yeri gösterelim
if (!array_key_exists($yer_anahtar, $gezi_noktalari)) {
    $detay = $gezi_noktalari['karanlik_kanyon'];
} else {
    $detay = $gezi_noktalari[$yer_anahtar];
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $detay['baslik']; ?> - Gezi Detayları</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8fafc; margin: 0; font-family: 'Segoe UI', sans-serif; color: #334155; }
        .detay-kapsam { max-width: 900px; margin: 40px auto; padding: 0 20px; box-sizing: border-box; }
        
        /* Geri Dön Butonu */
        .geri-btn { display: inline-flex; align-items: center; gap: 8px; color: #0284c7; text-decoration: none; font-weight: 600; font-size: 15px; margin-bottom: 20px; transition: color 0.2s; }
        .geri-btn:hover { color: #0369a1; }

        /* Büyük Görsel Alanı */
        .detay-gorsel-kapsam { position: relative; width: 100%; height: 400px; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .detay-gorsel-kapsam img { width: 100%; height: 100%; object-fit: cover; }
        .detay-overlay { position: absolute; bottom: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 60%); display: flex; flex-direction: column; justify-content: flex-end; padding: 30px; box-sizing: border-box; color: white; }
        .detay-overlay h1 { font-size: 32px; margin: 0 0 8px 0; font-weight: 800; }
        
        /* İçerik Kartları */
        .bilgi-karti { background: white; border-radius: 14px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; margin-bottom: 25px; }
        .bilgi-karti h3 { font-size: 18px; margin: 0 0 12px 0; color: #1e293b; display: flex; align-items: center; gap: 10px; font-weight: 700; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; }
        .bilgi-karti p { font-size: 15px; color: #475569; line-height: 1.7; margin: 0; }
        
        /* Alt Bölüm Puanlama paneli */
        .meta-paneli { display: flex; gap: 15px; font-size: 14px; font-weight: 500; }
        .meta-oge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 5px 12px; border-radius: 30px; backdrop-filter: blur(5px); }
    </style>
</head>
<body>

    <?php if(file_exists('header.php')) { include 'header.php'; } ?>

    <div class="detay-kapsam">
        <a href="javascript:history.back()" class="geri-btn">
            <i class="fas fa-arrow-left"></i> Önerilen Yerlere Geri Dön
        </a>

        <div class="detay-gorsel-kapsam">
            <img src="<?php echo $detay['gorsel']; ?>" alt="<?php echo $detay['baslik']; ?>">
            <div class="detay-overlay">
                <h1><?php echo $detay['baslik']; ?></h1>
                <div class="meta-paneli">
                    <div class="meta-oge"><i class="fas fa-map-marker-alt" style="color: #ef4444;"></i> <?php echo $detay['konum']; ?></div>
                    <div class="meta-oge" style="background: #fef08a; color: #854d0e;"><i class="fas fa-star"></i> <?php echo $detay['puan']; ?></div>
                </div>
            </div>
        </div>

        <div class="bilgi-karti">
            <h3><i class="fas fa-info-circle" style="color: #0284c7;"></i> Bölge Hakkında Bilgi</h3>
            <p><?php echo $detay['aciklama']; ?></p>
        </div>

        <div class="bilgi-karti">
            <h3><i class="fas fa-compass" style="color: #10b981;"></i> Neler Yapılır & Aktivite Rehberi</h3>
            <p><?php echo $detay['neler_yapilir']; ?></p>
        </div>

        <div class="bilgi-karti">
            <h3><i class="fas fa-route" style="color: #f59e0b;"></i> Nasıl Gidilir & Ulaşım</h3>
            <p><?php echo $detay['nasil_gidilir']; ?></p>
        </div>
    </div>

    <footer style="background: #1e293b; color: #94a3b8; text-align: center; padding: 25px 20px; font-size: 14px; border-top: 1px solid #334155; margin-top: 60px;">
        &copy; <?php echo date("Y"); ?> Gezi Rehberim - Tüm Hakları Saklıdır.
    </footer>

</body>
</html>