<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// URL'den gelen sayısal ID parametresini al (Yoksa varsayılan olarak 1 yani İtalya yap)
$gelen_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Sayıya göre hangi ülkenin havuz anahtarını seçeceğimizi belirliyoruz
if ($gelen_id === 2) {
    $secilen_ulke_slug = 'fransa';
} elseif ($gelen_id === 3) {
    $secilen_ulke_slug = 'almanya';
} elseif ($gelen_id === 4) {
    // 4 numaraya tıklandığında artık hiçbir harf engeline takılmadan direkt İspanya açılacak
    $secilen_ulke_slug = 'ispanya';
} else {
    // 1 numara veya geçersiz bir ID gelirse varsayılan İtalya
    $secilen_ulke_slug = 'italya';
}

// Ülke Bilgi Havuzu (Bu satırdan aşağısı eski haliyle aynen kalacak.

// Ülke Bilgi Havuzu
$ulke_havuzu = [
    'italya' => [
        'isim' => 'İtalya',
        'slogan' => 'Sanatın, Tarihin ve "La Dolce Vita" (Tatlı Hayat) Kültürünün Beşiği',
        'baskent' => 'Roma',
        'para_birimi' => 'Euro (€)',
        'dil' => 'İtalyanca',
        'priz' => 'Tip L / C (230V)',
        'renk' => '#008c45',
        'kapak' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=1600',
        'meshur' => [
            ['baslik' => 'Rönesans Sanatı', 'detay' => 'Leonardo da Vinci ve Michelangelo gibi dâhilerin doğum yeri olan ülke, dünya sanat mirasının merkezidir.', 'ikon' => 'fas fa-palette'],
            ['baslik' => 'Vespa & Tasarım', 'detay' => 'Dar İtalyan sokaklarında süzülen ikonik motorlar ve dünya modasına yön veren Milano tasarımları.', 'ikon' => 'fas fa-motorcycle'],
            ['baslik' => 'Tarihi Mimari', 'detay' => 'Kolezyum, Pisa Kulesi ve Pompei antik kenti gibi binlerce yıllık devasa açık hava müzeleri.', 'ikon' => 'fas fa-landmark']
        ],
        'gezilecekler' => [
            ['isim' => 'Roma (Kolezyum)', 'aciklama' => 'Gladyatör dövüşlerine ev sahipliği yapmış antik dünyanın en büyük amfitiyatrosu.', 'foto' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=500'],
            ['isim' => 'Venedik Kanalları', 'aciklama' => 'Sular üzerine kurulmuş büyüleyici şehirde gondollarla tarihi köprülerin altından geçin.', 'foto' => 'images/venedik.jpg'],
            ['isim' => 'Floransa (Duomo)', 'aciklama' => 'Rönesans mimarisinin kalbi, muhteşem katedraller ve sanat galerileriyle dolu bir masal şehri.', 'foto' => 'images/floransa.jpg']
        ],
        'gelenekler' => [
            'kurallar' => [
                'Öğleden sonra asla Cappuccino sipariş etmeyin; yerel halk bunu sadece kahvaltıda tüketir.',
                'Makarnayı asla bıçakla kesmeyin veya çatala kaşık yardımıyla sarmayın.',
                'Restoranlarda hesaba eklenen "Coperto" (masa düzeni ücreti) bir gelenektir, şaşırmayın.'
            ],
            'festival' => 'Venedik Karnavalı: Her yıl Şubat ayında düzenlenen, gizemli ve sanatsal maskelerin takıldığı dünyanın en ünlü maskeli festivalidir.'
        ],
        'mutfak' => [
            ['ad' => 'Gerçek Napoliten Pizza', 'detay' => 'İncecik odun ateşinde pişmiş hamur, taze mozzarella ve fesleğen yaprakları.', 'foto' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=400'],
            ['ad' => 'Tiramisu', 'detay' => 'Mascarpone peyniri ve espresso ile ıslatılmış savoyer bisküvilerinin eşsiz buluşması.', 'foto' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=400']
        ]
    ],
    'fransa' => [
        'isim' => 'Fransa',
        'slogan' => 'Modanın, Gastonominin ve Romantizmin Dünya Başkenti',
        'baskent' => 'Paris',
        'para_birimi' => 'Euro (€)',
        'dil' => 'Fransızca',
        'priz' => 'Tip E / C (230V)',
        'renk' => '#002395',
        'kapak' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1600',
        'meshur' => [
            ['baslik' => 'Yüksek Moda (Haute Couture)', 'detay' => 'Dünyanın en prestijli moda evlerine ve Paris Moda Haftası\'na ev sahipliği yapması.', 'ikon' => 'fas fa-shirt'],
            ['baslik' => 'Müze Kültürü', 'detay' => 'Mona Lisa tablosunun da sergilendiği dünyanın en büyük sanat müzesi olan Louvre Müzesi.', 'ikon' => 'fas fa-building-columns'],
            ['baslik' => 'Kozmetik & Parfüm', 'detay' => 'Grasse kasabasındaki lavanta tarlalarından dünyaya yayılan eşsiz esans ve parfüm formülleri.', 'ikon' => 'fas fa-flask']
        ],
        'gezilecekler' => [
            ['isim' => 'Paris (Eyfel Kulesi)', 'aciklama' => 'Şehrin silüetini oluşturan, geceleri ışık şovlarıyla büyüleyen dünyanın en ikonik kulesi.', 'foto' => 'images/eyfel.jpg'],
            ['isim' => 'Louvre Müzesi', 'aciklama' => 'Tarih öncesinden günümüze kadar uzanan milyonlarca esere ev sahipliği yapan piramit tasarımlı müze.', 'foto' => 'images/louvre.jpg'],
            ['isim' => 'Fransız Rivierası (Nice)', 'aciklama' => 'Akdeniz\'in masmavi sularıyla çevrili lüks, sanat og doğanın birleştiği rüya gibi sahil şeridi.', 'foto' => 'images/riverası.jpg']
        ],
        'gelenekler' => [
            'kurallar' => [
                'Bir dükkana girdiğinizde mutlaka "Bonjour" (Merhaba) diyerek selam verin, bu çok önemlidir.',
                'Restoranlarda garsonu yüksek sesle çağırmak kaba sayılır, göz teması kurmayı deneyin.',
                'Sosyal hayatta acele ettirilmekten hoşlanmazlar, hizmet sektöründe sabırlı olun.'
            ],
            'festival' => 'Cannes Film Festivali: Her yıl Mayıs ayında dünya sinemasının kalbinin attığı, kırmızı halı geçişleriyle ünlü elit festival.'
        ],
        'mutfak' => [
            ['ad' => 'Kruvasan & Makaron', 'detay' => 'Kat kat tereyağlı çıtır çıtır Fransız çöreği ve rengarenk badem unlu saray tatlıları.', 'foto' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=400'],
            ['ad' => 'Ratatouille', 'detay' => 'Taze Akdeniz sebzelerinin zeytinyağı ve özel otlarla fırınlandığı geleneksel sebze yemeği.', 'foto' =>'images/ratato.jpg ']
        ]
    ],
    'almanya' => [
        'isim' => 'Almanya',
        'slogan' => 'Disiplinin, Mühendisliğin ve Masalsı Şatoların Ülkesi',
        'baskent' => 'Berlin',
        'para_birimi' => 'Euro (€)',
        'dil' => 'Almanca',
        'priz' => 'Tip F / C (230V)',
        'renk' => '#ffce00',
        'kapak' => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=1600',
        'meshur' => [
            ['baslik' => 'Üstün Mühendislik', 'detay' => 'Dünyanın en kaliteli otomobillerinin üretildiği, hız sınırı olmayan otobanların (Autobahn) ülkesi.', 'ikon' => 'fas fa-gear'],
            ['baslik' => 'Kara Ormanlar & Doğa', 'detay' => 'Grimm Kardeşler\'in masallarına ilham veren sık, gizemli ve yemyeşil orman koridorları.', 'ikon' => 'fas fa-tree'],
            ['baslik' => 'Ekmek Çeşitliliği', 'detay' => 'Kültür mirası olarak kabul edilen, 3000\'den fazla tescilli ekmek türünün yapıldığı fırıncılık.', 'ikon' => 'fas fa-bread-slice']
        ],
        'gezilecekler' => [
            ['isim' => 'Neuschwanstein Şatosu', 'aciklama' => 'Disney şatosuna ilham veren, Bavyera Alpleri\'nin zirvesinde yer alan masalsı saray.', 'foto' => 'images/images.jpg'],
            ['isim' => 'Berlin Duvarı (East Side)', 'aciklama' => 'Soğuk savaş döneminin izlerini taşıyan, günümüzde açık hava sanat galerisine dönen tarihi duvar.', 'foto' => 'images/berlin_duvari.jpg'],
            ['isim' => 'Köln Katedrali', 'aciklama' => 'Gotik mimarinin dünyadaki en görkemli örneği olan, yapımı tam 632 yıl süren devasa yapı.', 'foto' => 'images/koln.jpg']
        ],
        'gelenekler' => [
            'kurallar' => [
                'Pazar günleri "Sessizlik Günü"dür. Çamaşır makinesi çalıştırmak veya gürültü yapmak yasaktır.',
                'Geri dönüşüm (Pfand) sistemine çok dikkat ederler; şişeleri çöpe atmak yerine makinelere iade edin.',
                'Randevulara tam vaktinde, hatta 5 dakika önce gitmek altın kuraldır.'
            ],
            'festival' => 'Oktoberfest: Münih kentinde düzenlenen, geleneksel Bavyera kıyafetleri ve müzikleri eşliğinde yapılan dünyanın en büyük halk festivalidir.'
        ],
        'mutfak' => [
            ['ad' => 'Pretzel (Brezel)', 'detay' => 'Üzeri kalın tuz taneleriyle kaplı, içi yumuşak dışı çıtır geleneksel Alman çöreği.', 'foto' => 'images/pretzel.jpg'],
            ['ad' => 'Kara Orman Pastası', 'detay' => 'Yoğun çikolata, vişne taneleri ve taze kremanın birleştiği dünyaca ünlü hafif pasta.', 'foto' => 'images/kara_orman_pastasi.webp']
        ]
    ],
    'ispanya' => [
        'isim' => 'İspanya',
        'slogan' => 'Bitmeyen Enerjinin, Flamenkonun ve Akdeniz Güneşinin Sıcaklığı',
        'baskent' => 'Madrid',
        'para_birimi' => 'Euro (€)',
        'dil' => 'İspanyolca',
        'priz' => 'Tip F / C (230V)',
        'renk' => '#c60b1e',
        'kapak' => 'https://images.unsplash.com/photo-1543783207-ec64e4d95325?w=1600',
        'meshur' => [
            ['baslik' => 'Flamenko Dansı', 'detay' => 'Endülüs topraklarından doğan, gitar tınıları ve ayak ritimleriyle duyguyu zirveye taşıyan tutkulu dans.', 'ikon' => 'fas fa-guitar'],
            ['baslik' => 'Siesta Kültürü', 'detay' => 'Günün en sıcak saatlerinde (14:00 - 17:00) hayatı durdurup dinlenme ve öğle uykusu geleneği.', 'ikon' => 'fas fa-bed'],
            ['baslik' => 'Gaudí Mimarisi', 'detay' => 'Barselona sokaklarında görebileceğiniz, doğadan ilham alan sıra dışı ve rengarenk modernizm akımı.', 'ikon' => 'fas fa-mosaic']
        ],
        'gezilecekler' => [
            ['isim' => 'La Sagrada Família', 'aciklama' => 'Antoni Gaudí\'nin bitmeyen şaheseri olan, doğadan ilham alan sütunlarıyla ünlü devasa bazilika.', 'foto' => 'images/sagrada.jpg'],
            ['isim' => 'El Hamra Sarayı (Granada)', 'aciklama' => 'Endülüs İslam mimarisinin zirve noktası, dantel gibi işlenmiş duvarları ve havuzlu bahçeleri.', 'foto' => 'images/el_hamra.jpg'],
            ['isim' => 'İbiza Adaları', 'aciklama' => 'Dünyanın en popüler eğlence, plaj ve yaz turizmi merkezlerinden biri olan dinamik ada.', 'foto' => 'images/ibiza.jpg']
        ],
        'gelenekler' => [
            'kurallar' => [
                'Akşam yemekleri çok geç yenir. Restoranlar genelde saat 21:00\'den önce akşam servisini açmaz.',
                'Pazar günleri büyük şehirler dahil neredeyse tüm dükkanlar ve marketler kapalıdır.',
                'İletişimde oldukça cana yakın ve yüksek sesle konuşurlar, mesafeli tavırları pek sevmezler.'
            ],
            'festival' => 'La Tomatina (Domates Festivali): Valencia\'nın Bunol kasabasında her yıl tonlarca domatesin sokaklarda birbirine fırlatıldığı çılgın festival.'
        ],
        'mutfak' => [
            ['ad' => 'Paella', 'detay' => 'Safranlı pirinç pilavının deniz ürünleri veya taze sebzelerle büyük özel tavalarda pişmesi.', 'foto' => 'images/paella.jpg'],
            ['ad' => 'Tapas & Churros', 'detay' => 'İçeceklerin yanında sunulan küçük atıştırmalık mezeler ve çikolataya batırılan tatlı halkalar.', 'foto' => 'images/tapas.jpg']
        ]
    ]
];

if (!array_key_exists($secilen_ulke_slug, $ulke_havuzu)) {
    $secilen_ulke_slug = 'italya';
}

$ulke = $ulke_havuzu[$secilen_ulke_slug];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $ulke['isim']; ?> Gezi Rehberi - Gezi Rehberim</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --ulke-renk: <?php echo $ulke['renk']; ?>; }
        .ulke-sayfa-body { font-family: 'Poppins', sans-serif; background: #f8fafc; color: #1e293b; margin: 0; padding: 0; }
        
        .hero-banner { position: relative; height: 450px; background: url('<?php echo $ulke['kapak']; ?>') center/cover no-repeat; display: flex; align-items: center; justify-content: center; color: white; text-align: center; }
        .hero-banner::before { content: ''; position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(15, 23, 42, 0.6); }
        .hero-detay { position: relative; z-index: 2; max-width: 800px; padding: 0 20px; }
        .hero-detay h1 { font-size: 52px; font-weight: 800; margin: 0 0 10px 0; text-transform: uppercase; letter-spacing: 2px; }
        .hero-detay p { font-size: 18px; font-style: italic; opacity: 0.9; margin-bottom: 30px; }
        
        .kunye-kart { display: flex; justify-content: space-around; background: white; max-width: 900px; margin: -50px auto 40px auto; padding: 20px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); position: relative; z-index: 10; flex-wrap: wrap; gap: 15px; }
        .kunye-oge { text-align: center; flex: 1; min-width: 150px; }
        .kunye-oge i { font-size: 24px; color: var(--ulke-renk); margin-bottom: 8px; }
        .kunye-oge span { display: block; font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; }
        .kunye-oge strong { display: block; font-size: 14px; color: #1e293b; margin-top: 2px; }

        .ana-icerik-alani { max-width: 1100px; margin: 0 auto; padding: 0 20px 60px 20px; }
        .bolum-baslik { font-size: 24px; font-weight: 700; color: #0f172a; margin: 40px 0 20px 0; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; }
        .bolum-baslik i { color: var(--ulke-renk); }

        .meshur-izgara { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .meshur-kart { background: white; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; transition: transform 0.3s; }
        .meshur-kart:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.02); }
        .meshur-ust { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .meshur-ust i { font-size: 20px; background: #f1f5f9; padding: 10px; border-radius: 50%; color: var(--ulke-renk); }
        .meshur-ust h3 { margin: 0; font-size: 16px; font-weight: 700; color: #1e293b; }
        .meshur-kart p { font-size: 13px; color: #64748b; line-height: 1.6; margin: 0; }

        .gezi-izgara { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 25px; }
        .gezi-kart { background: white; border-radius: 14px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01); }
        .gezi-resim { height: 200px; width: 100%; object-fit: cover; }
        .gezi-icerik { padding: 20px; }
        .gezi-icerik h3 { margin: 0 0 8px 0; font-size: 17px; font-weight: 700; color: #1e293b; }
        .gezi-icerik p { font-size: 13px; color: #64748b; line-height: 1.6; margin: 0; }

        .kultur-blok { display: grid; grid-template-columns: 1.5fr 1fr; gap: 25px; }
        .kultur-kart { background: white; padding: 25px; border-radius: 14px; border: 1px solid #e2e8f0; }
        .kultur-kart h3 { margin: 0 0 15px 0; font-size: 16px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px; }
        .kultur-liste { list-style: none; padding: 0; margin: 0; }
        .kultur-liste li { font-size: 13px; color: #475569; padding: 8px 0; border-bottom: 1px solid #f1f5f9; display: flex; gap: 10px; align-items: flex-start; }
        .kultur-liste li i { color: #e11d48; margin-top: 3px; }

        .mutfak-izgara { display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 20px; }
        .mutfak-kart { background: white; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; overflow: hidden; }
        .mutfak-resim { width: 150px; height: 100%; object-fit: cover; }
        .mutfak-detay { padding: 20px; flex: 1; }
        .mutfak-detay h3 { margin: 0 0 6px 0; font-size: 16px; font-weight: 700; color: #1e293b; }
        .mutfak-detay p { font-size: 13px; color: #64748b; line-height: 1.5; margin: 0; }
    </style>
</head>
<body class="ulke-sayfa-body">

    <?php if(file_exists('header.php')) { include 'header.php'; } ?>

    <div class="hero-banner">
        <div class="hero-detay">
            <h1><?php echo $ulke['isim']; ?></h1>
            <p>"<?php echo $ulke['slogan']; ?>"</p>
        </div>
    </div>

    <div class="kunye-kart">
        <div class="kunye-oge">
            <i class="fas fa-city"></i>
            <span>BAŞKENT</span>
            <strong><?php echo $ulke['baskent']; ?></strong>
        </div>
        <div class="kunye-oge">
            <i class="fas fa-coins"></i>
            <span>PARA BİRİMİ</span>
            <strong><?php echo $ulke['para_birimi']; ?></strong>
        </div>
        <div class="kunye-oge">
            <i class="fas fa-language"></i>
            <span>RESMİ DİL</span>
            <strong><?php echo $ulke['dil']; ?></strong>
        </div>
        <div class="kunye-oge">
            <i class="fas fa-plug"></i>
            <span>PRİZ / GÜÇ</span>
            <strong><?php echo $ulke['priz']; ?></strong>
        </div>
    </div>

    <div class="ana-icerik-alani">
        
        <h2 class="bolum-baslik"><i class="fas fa-star"></i> Ülkenin Nesi Meşhur?</h2>
        <div class="meshur-izgara">
            <?php foreach($ulke['meshur'] as $m): ?>
                <div class="meshur-kart">
                    <div class="meshur-ust">
                        <i class="<?php echo $m['ikon']; ?>"></i>
                        <h3><?php echo $m['baslik']; ?></h3>
                    </div>
                    <p><?php echo $m['detay']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <h2 class="bolum-baslik"><i class="fas fa-map-marked-alt"></i> Görülmesi Gereken İkonik Rotalar</h2>
        <div class="gezi-izgara">
            <?php foreach($ulke['gezilecekler'] as $g): ?>
                <div class="gezi-kart">
                    <img src="<?php echo $g['foto']; ?>" class="gezi-resim" alt="<?php echo $g['isim']; ?>">
                    <div class="gezi-icerik">
                        <h3><?php echo $g['isim']; ?></h3>
                        <p><?php echo $g['aciklama']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2 class="bolum-baslik"><i class="fas fa-masks-theater"></i> Kültür, Gelenekler ve Sosyal Yaşam</h2>
        <div class="kultur-blok">
            <div class="kultur-kart">
                <h3><i class="fas fa-triangle-exclamation" style="color:#d97706;"></i> Seyahatte Yapılmaması Gerekenler (Sosyal Kurallar)</h3>
                <ul class="kultur-liste">
                    <?php foreach($ulke['gelenekler']['kurallar'] as $kural): ?>
                        <li><i class="fas fa-ban"></i> <span><?php echo $kural; ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="kultur-kart" style="background: linear-gradient(135deg, #ffffff, #f8fafc); border-left: 4px solid var(--ulke-renk);">
                <h3><i class="fas fa-calendar-check" style="color:var(--ulke-renk);"></i> En Büyük Kültürel Festivali</h3>
                <p style="font-size: 13px; color:#475569; line-height:1.7; margin:0;">
                    <?php echo $ulke['gelenekler']['festival']; ?>
                </p>
            </div>
        </div>

        <h2 class="bolum-baslik"><i class="fas fa-utensils"></i> Geleneksel Mutfak: Ne Yenir?</h2>
        <div class="mutfak-izgara">
            <?php foreach($ulke['mutfak'] as $yemek): ?>
                <div class="mutfak-kart">
                    <img src="<?php echo $yemek['foto']; ?>" class="mutfak-resim" alt="<?php echo $yemek['ad']; ?>">
                    <div class="mutfak-detay">
                        <h3><?php echo $yemek['ad']; ?></h3>
                        <p><?php echo $yemek['detay']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

</body>
</html>