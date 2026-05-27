<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// URL'den gelen bölge ID'sini al (Yoksa varsayılan olarak 1 yani Marmara yap)
$gelen_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Türkiye 7 Bölge ve Detaylı Şehir Listesi (Bölge Başına 6 Şehir)
$bolge_havuzu = [
    1 => [
        'isim' => 'Marmara Bölgesi',
        'slogan' => 'Kıtaların Buluştuğu, Tarih ve Sanayinin Kalbi',
        'renk' => '#0284c7',
        'kapak' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?w=1600',
        'sehirler' => [
            ['ad' => 'İstanbul', 'meshur' => 'Tarihi Yarımada, Boğaz Turu, Kız Kulesi', 'yapilacak' => 'Ayasofya ve Topkapı Sarayı\'nı gez, vapurla kıtalar arası geçiş yap.', 'foto' => 'images/istanbull.jpg'],
            ['ad' => 'Bursa', 'meshur' => 'İskender Kebabı, Uludağ, İpek Kumaşları', 'yapilacak' => 'Tarihi Çınar altında çay iç, Uludağ\'da teleferik keyfi yap ve Yeşil Türbe\'yi ziyaret et.', 'foto' => 'images/bursa.jpg'],
            ['ad' => 'Edirne', 'meshur' => 'Selimiye Camii, Tava Ciğeri, Kırkpınar Yağlı Güreşleri', 'yapilacak' => 'Mimar Sinan\'ın ustalık eseri Selimiye\'yi gör, tarihi Meriç Köprüsü\'nde gün batımını izle.', 'foto' => 'images/edirne.jpg'],
            ['ad' => 'Çanakkale', 'meshur' => 'Troya Atı, Şehitlik Anıtı, Assos Antik Kenti', 'yapilacak' => 'Gelibolu Yarımadası Tarihi Alanı\'nı ziyaret et, Bozcaada sokaklarında yürü.', 'foto' => 'images/çanakkale.jpg'],
            ['ad' => 'Sakarya', 'meshur' => 'Sapanca Gölü, Islama Köfte, Kabak Tatlısı', 'yapilacak' => 'Sapanca Gölü kenarında bisiklet sür, Maşukiye\'de doğa yürüyüşü ve ATV turu yap.', 'foto' => 'images/sakarya.jpg'],
            ['ad' => 'Tekirdağ', 'meshur' => 'Tekirdağ Köftesi, Şarköy Üzüm Bağları, Uçmakdere', 'yapilacak' => 'Uçmakdere yamaç paraşütü merkezinde gökyüzünden Marmara\'yı izle, sahilde yürüyüş yap.', 'foto' => 'images/tekirdag.jpg']
        ]
    ],
    2 => [
        'isim' => 'İç Anadolu Bölgesi',
        'slogan' => 'Medeniyetlerin Doğduğu Tarihi Bozkır',
        'renk' => '#d97706',
        'kapak' => 'images/icanadolu.jpg',
        'sehirler' => [
            ['ad' => 'Ankara', 'meshur' => 'Anıtkabir, Ankara Kalesi, Ankara Tavası', 'yapilacak' => 'Anıtkabir\'de saygı duruşunda bulun, Hamamönü restore edilmiş tarihi evlerini gez.', 'foto' => 'images/ankara.jpg'],
            ['ad' => 'Nevşehir', 'meshur' => 'Kapadokya Peri Bacaları, Balon Turları', 'yapilacak' => 'Gün doğumunda sıcak hava balonuna bin, Göreme Açık Hava Müzesi\'ni keşfet.', 'foto' => 'images/nevsehir.jpg'],
            ['ad' => 'Konya', 'meshur' => 'Mevlana Müzesi, Etli Ekmek, Şeb-i Arus', 'yapilacak' => 'Mevlana Müzesi ve Türbesi\'ni gez, Sille Antik Köyü\'nün tarihi dokusunu incele.', 'foto' => 'images/konya.jpg'],
            ['ad' => 'Eskişehir', 'meshur' => 'Porsuk Çayı, Odunpazarı Evleri, Çibörek', 'yapilacak' => 'Porsuk Çayı\'nda gondol turuna katıl, Sazova Parkı\'ndaki masal şatosunu gez.', 'foto' => 'images/eskisehir.webp'],
            ['ad' => 'Kayseri', 'meshur' => 'Erciyes Dağı, Kayseri Mantısı, Pastırma', 'yapilacak' => 'Erciyes Kayak Merkezi\'nde kış sporları yap, tarihi Kapalı Çarşı\'dan alışveriş yap.', 'foto' => 'images/kayseri.webp'],
            ['ad' => 'Sivas', 'meshur' => 'Divriği Ulu Camii, Sivas Köftesi, Kangal', 'yapilacak' => 'UNESCO miras listesindeki Divriği Ulu Camii\'nin taş işçiliğini yerinde gör.', 'foto' => 'images/images (1).jpg']
        ]
    ],
    3 => [
        'isim' => 'Ege Bölgesi',
        'slogan' => 'Zeytin Ağaçlarının ve Antik Kentlerin Eşsiz Maviliği',
        'renk' => '#059669',
        'kapak' => 'images/egebolgrsi.jpg',
        'sehirler' => [
            ['ad' => 'İzmir', 'meshur' => 'Saat Kulesi, Kordon Boyu, Efes Antik Kenti', 'yapilacak' => 'Efes ve Meryem Ana Evi\'ni ziyaret et, Kordon sahilinde yürüyüş yap.', 'foto' => 'images/indir.jpg'],
            ['ad' => 'Muğla', 'meshur' => 'Bodrum, Marmaris, Fethiye Ölüdeniz', 'yapilacak' => 'Fethiye Babadağ\'dan yamaç paraşütü yap, teknelerle eşsiz koyları gez.', 'foto' => 'images/mugla.jpg'],
            ['ad' => 'Aydın', 'meshur' => 'Kuşadası, Didim Apollon Tapınağı, İncir', 'yapilacak' => 'Didim\'de devasa Apollon tapınağını incele, Kuşadası Milli Parkı\'nda yüz.', 'foto' => 'images/aydin.webp'],
            ['ad' => 'Denizli', 'meshur' => 'Pamukkale Travertenleri, Hierapolis Antik Kenti', 'yapilacak' => 'Pamukkale\'nin şifalı beyaz traverten havuzlarında yalın ayak yürü.', 'foto' => 'images/denizli.jpg'],
            ['ad' => 'Manisa', 'meshur' => 'Mesir Macunu, Spil Dağı, Muradiye Camii', 'yapilacak' => 'Spil Dağı Milli Parkı\'ndaki yılkı atlarını gör, Mesir Festivali\'ne katıl.', 'foto' => 'images/manisa.jpg'],
            ['ad' => 'Afyonkarahisar', 'meshur' => 'Afyon Lokumu, Sucuk, Termal Kaplıcalar', 'yapilacak' => 'Tarihi Afyon Kalesi\'ne tırman, lüks termal kaplıcalarda yorgunluk at.', 'foto' => 'images/afyon.jpg']
        ]
    ],
    4 => [
        'isim' => 'Akdeniz Bölgesi',
        'slogan' => 'Toroslar\'ın Gölgesinde Bitmeyen Yaz Güneşi',
        'renk' => '#dc2626',
        'kapak' => 'images/akdeniz.jpg',
        'sehirler' => [
            ['ad' => 'Antalya', 'meshur' => 'Kaleiçi, Düden Şelalesi, Olimpos, Dünyaca ünlü oteller', 'yapilacak' => 'Tarihi Kaleiçi sokaklarında kaybol, Aspendos Antik Tiyatrosu\'nu gez.', 'foto' => 'images/antalya.jpg'],
            ['ad' => 'Adana', 'meshur' => 'Adana Kebabı, Şalgam Suyu, Tarihi Taşköprü', 'yapilacak' => 'Dünyanın kullanılan en eski köprüsü olan Taşköprü\'de yürüyüş yap.', 'foto' => 'images/adana.jpg'],
            ['ad' => 'Mersin', 'meshur' => 'Tantuni, Kızkalesi, Cennet-Cehennem Obrukları', 'yapilacak' => 'Denizin ortasındaki Kızkalesi\'ne tekneyle git, büyük obrukları incele.', 'foto' => 'images/mersin.jpg'],
            ['ad' => 'Hatay', 'meshur' => 'Künefe, Antakya Mozaik Müzesi, Tepsi Kebabı', 'yapilacak' => 'Dünyanın en büyük mozaik müzelerinden birini gez, yöresel lezzetleri tadın.', 'foto' => 'images/hatay.jpg'],
            ['ad' => 'Kahramanmaraş', 'meshur' => 'Maraş Dondurması, Tarhana, Yeşilgöz Obruğu', 'yapilacak' => 'Eski usul çengelli dövme dondurma ye, Yeşilgöz Obruğu\'nda mola ver.', 'foto' => 'images/kahramanmaras.jpg'],
            ['ad' => 'Isparta', 'meshur' => 'Gül Bahçeleri, Lavanta Kokulu Köy (Kuyucak)', 'yapilacak' => 'Kuyucak köyünde mor lavanta tarlalarında muhteşem fotoğraflar çekil.', 'foto' => 'images/isparta.jpg']
        ]
    ],
    5 => [
        'isim' => 'Karadeniz Bölgesi',
        'slogan' => 'Bulutların Üzerinde Sonsuz Bir Yeşil Macera',
        'renk' => '#15803d',
        'kapak' => 'images/karadeniz.jpg',
        'sehirler' => [
            ['ad' => 'Trabzon', 'meshur' => 'Sümela Manastırı, Uzungöl, Akçaabat Köftesi', 'yapilacak' => 'Karadağ\'ın eteklerine kurulu Sümela Manastırı\'nın eşsiz tarihini incele.', 'foto' => 'images/trabzon.jpg'],
            ['ad' => 'Rize', 'meshur' => 'Ayder Yaylası, Rize Çayı, Fırtına Deresi', 'yapilacak' => 'Fırtına Deresi üzerinde rafting heyecanı yaşa, Pokut\'ta bulutları izle.', 'foto' => 'images/rize.jpg'],
            ['ad' => 'Samsun', 'meshur' => 'Bandırma Vapuru, Atatürk Anıtı, Bafra Pidesi', 'yapilacak' => 'Milli mücadelenin başladığı Bandırma Vapuru Müzesi\'ni gururla gez.', 'foto' => 'images/samsun.jpg'],
            ['ad' => 'Ordu', 'meshur' => 'Boztepe Teleferik, Ordu Fındığı, Yason Burnu', 'yapilacak' => 'Teleferikle Boztepe\'ye çıkıp Karadeniz ve şehri kuş bakışı izle.', 'foto' => 'images/ordu.jpg'],
            ['ad' => 'Amasya', 'meshur' => 'Kral Kaya Mezarları, Amasya Elması', 'yapilacak' => 'Yeşilırmak kenarındaki Osmanlı dönemi Yalıboyu Evleri arasında yürü.', 'foto' => 'images/amasya.jpg'],
            ['ad' => 'Sinop', 'meshur' => 'Tarihi Sinop Cezaevi, Hamsilos Koyu, Mantı', 'yapilacak' => 'Türkiye\'nin tek fiyordu olan sakin Hamsilos Koyu\'nda doğayla baş başa kal.', 'foto' => 'images/sinop.jpg']
        ]
    ],
    6 => [
        'isim' => 'Doğu Anadolu Bölgesi',
        'slogan' => 'Zirvelerin, Kalelerin ve Karlar Altındaki Tarihin Kadim Toprağı',
        'renk' => '#475569',
        'kapak' => 'images/doguanadolu.jpg',
        'sehirler' => [
            ['ad' => 'Erzurum', 'meshur' => 'Palandöken Kayak Merkezi, Cağ Kebabı, Çifte Minareli Medrese', 'yapilacak' => 'Palandöken\'de kış kayağı yap, Oltu taşı çarşısından alışveriş et.', 'foto' => 'images/erzurum.jpg'],
            ['ad' => 'Van', 'meshur' => 'Van Gölü, Akdamar Adası, Van Kedisi, Meşhur Van Kahvaltısı', 'yapilacak' => 'Tekneyle Akdamar Adası\'na geçip tarihi Ermeni kilisesini ziyaret et.', 'foto' => 'images/van.jpg'],
            ['ad' => 'Kars', 'meshur' => 'Ani Harabeleri, Kars Kaşarı, Çıldır Gölü Atlı Kızak', 'yapilacak' => 'Kışın donan Çıldır Gölü üzerinde atlı kızaklarla gez, Ani harabelerini gör.', 'foto' => 'images/kars.jpg'],
            ['ad' => 'Ağrı', 'meshur' => 'İshak Paşa Sarayı, Ağrı Dağı', 'yapilacak' => 'Osmanlı mimarisinin doğudaki en şık örneği İshak Paşa Sarayı\'nı fotoğrafla.', 'foto' => 'images/agri.jpg'],
            ['ad' => 'Erzincan', 'meshur' => 'Erzincan Tulum Peyniri, Karanlık Kanyon', 'yapilacak' => 'Dünyanın en derin kanyonlarından olan Karanlık Kanyon\'da tekne turu yap.', 'foto' => 'images/erzincan.jpg'],
            ['ad' => 'Malatya', 'meshur' => 'Malatya Kayısısı, Aslantepe Höyüğü', 'yapilacak' => 'UNESCO tescilli dünyanın en eski bürokrasi sarayı Aslantepe\'yi keşfet.', 'foto' => 'images/malatya.jpg']
        ]
    ],
    7 => [
        'isim' => 'Güneydoğu Anadolu Bölgesi',
        'slogan' => 'Medeniyetlerin Sıfır Noktası, Taşın ve Lezzetin Büyüsü',
        'renk' => '#b45309',
        'kapak' => 'images/güneydogu.jpg',
        'sehirler' => [
            ['ad' => 'Şanlıurfa', 'meshur' => 'Göbeklitepe, Balıklıgöl, Çiğ Köfte, Sıra Geceleri', 'yapilacak' => 'İnsanlık tarihini başlatan 12 bin yıllık Göbeklitepe tapınaklarını gör.', 'foto' => 'images/urfa.webp'],
            ['ad' => 'Mardin', 'meshur' => 'Tarihi Taş Evler, Deyrulzafaran Manastırı, Gümüş Telkari', 'yapilacak' => 'Eski Mardin sokaklarında yürüyüp Mezopotamya ovasına karşı kahve iç.', 'foto' => 'images/mardin.jpg'],
            ['ad' => 'Gaziantep', 'meshur' => 'Zeugma Müzesi (Çingene Kızı), Dünya Gastronomisi, Baklava', 'yapilacak' => 'Tarihi Bakırcılar Çarşısı\'nı gez, ödüllü mutfağın yemeklerini tadın.', 'foto' => 'images/antep.jpg'],
            ['ad' => 'Adıyaman', 'meshur' => 'Nemrut Dağı Devasa Heykelleri, Cendere Köprüsü', 'yapilacak' => 'Nemrut Dağı zirvesinde dev kral og tanrı heykelleri arasında gün batımını izle.', 'foto' =>'images/adiyaman.jpg'],
            ['ad' => 'Diyarbakır', 'meshur' => 'Diyarbakır Surları, Hevsel Bahçeleri, Ciğer Kebabı', 'yapilacak' => 'Tarihi Hasan Paşa Hanı\'nda şark kahvaltısı yap, devasa surlarda yürü.', 'foto' => 'images/diyarbakir.jpg'],
            ['ad' => 'Batman', 'meshur' => 'Hasankeyf Antik Kenti ve Müze Köy Alanı', 'yapilacak' => 'Dicle nehri kenarındaki yeni Hasankeyf müze yerleşkesini ve mağaraları gez.', 'foto' => 'images/batman.jpg']
        ]
    ]
];

if (!array_key_exists($gelen_id, $bolge_havuzu)) { $gelen_id = 1; }
$bolge = $bolge_havuzu[$gelen_id];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $bolge['isim']; ?> Gezi Rehberi - Türkiye Turu</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --bolge-renk: <?php echo $bolge['renk']; ?>; }
        .bolge-body { font-family: 'Poppins', sans-serif; background: #f8fafc; color: #1e293b; margin:0; padding:0; }
        .bolge-hero { position: relative; height: 380px; background: url('<?php echo $bolge['kapak']; ?>') center/cover no-repeat; display: flex; align-items: center; justify-content: center; color: white; text-align: center; }
        .bolge-hero::before { content: ''; position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(15, 23, 42, 0.55); }
        .hero-metin { position: relative; z-index: 2; max-width: 800px; padding: 0 20px; }
        .hero-metin h1 { font-size: 46px; font-weight: 800; margin: 0 0 10px 0; letter-spacing: 1px; }
        .hero-metin p { font-size: 18px; font-style: italic; opacity: 0.95; margin: 0; }
        .bolge-konteyner { max-width: 1200px; margin: 40px auto; padding: 0 20px 60px 20px; }
        .baslik-bar { font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 30px; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #e2e8f0; padding-bottom: 12px; }
        .baslik-bar i { color: var(--bolge-renk); }
        .sehir-izgara { display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 30px; }
        .sehir-kart { background: white; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); transition: all 0.3s ease; display: flex; flex-direction: column; }
        .sehir-kart:hover { transform: translateY(-6px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.06); border-color: var(--bolge-renk); }
        .sehir-resim-kutusu { position: relative; height: 220px; width: 100%; overflow: hidden; }
        .sehir-resim { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
        .sehir-kart:hover .sehir-resim { transform: scale(1.05); }
        .sehir-isim-etiket { position: absolute; bottom: 15px; left: 15px; background: var(--bolge-renk); color: white; padding: 6px 16px; font-weight: 700; font-size: 15px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.15); }
        .sehir-bilgi-alani { padding: 22px; flex-grow: 1; display: flex; flex-direction: column; gap: 15px; }
        .bilgi-satir { display: flex; gap: 12px; align-items: flex-start; }
        .bilgi-satir i { font-size: 16px; background: #f1f5f9; padding: 10px; border-radius: 10px; color: var(--bolge-renk); flex-shrink: 0; }
        .satir-detay h4 { margin: 0 0 4px 0; font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .satir-detay p { margin: 0; font-size: 14px; color: #1e293b; line-height: 1.5; }
        .kesfet-btn { display: inline-block; width: calc(100% - 44px); margin: 0 22px 22px 22px; text-align: center; background: #f1f5f9; color: #1e293b; padding: 12px 0; font-size: 14px; font-weight: 600; text-decoration: none; border-radius: 10px; border: 1px solid #e2e8f0; transition: all 0.2s ease; }
        .sehir-kart:hover .kesfet-btn { background: var(--bolge-renk); color: white; border-color: var(--bolge-renk); }
    </style>
</head>
<body class="bolge-body">

    <?php if(file_exists('header.php')) { include 'header.php'; } ?>

    <div class="bolge-hero">
        <div class="hero-metin">
            <h1><?php echo $bolge['isim']; ?></h1>
            <p><?php echo $bolge['slogan']; ?></p>
        </div>
    </div>

    <div class="bolge-konteyner">
        <h2 class="baslik-bar"><i class="fas fa-map-location-dot"></i> Bölgenin Öne Çıkan 6 Şehri</h2>
        
        <div class="sehir-izgara">
            <?php foreach($bolge['sehirler'] as $sira => $sehir): ?>
                <div class="sehir-kart">
                    <div class="sehir-resim-kutusu">
                        <img src="<?php echo $sehir['foto']; ?>" class="sehir-resim" alt="<?php echo $sehir['ad']; ?>">
                        <div class="sehir-isim-etiket"><?php echo $sehir['ad']; ?></div>
                    </div>
                    <div class="sehir-bilgi-alani">
                        <div class="bilgi-satir">
                            <i class="fas fa-star"></i>
                            <div class="satir-detay">
                                <h4>Nesi Meşhur?</h4>
                                <p><?php echo $sehir['meshur']; ?></p>
                            </div>
                        </div>
                        <div class="bilgi-satir">
                            <i class="fas fa-compass"></i>
                            <div class="satir-detay">
                                <h4>Neler Yapılır?</h4>
                                <p><?php echo $sehir['yapilacak']; ?></p>
                            </div>
                        </div>
                    </div>

                    <a href="sehir.php?id=<?php echo $gelen_id; ?>&sehir_sira=<?php echo $sira; ?>" class="kesfet-btn">
                        Keşfet <i class="fas fa-arrow-right" style="margin-left: 5px; font-size: 12px;"></i>
                    </a>

                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>