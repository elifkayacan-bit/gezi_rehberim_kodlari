<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// URL'den gelen sayısal kimlikleri al
$gelen_bolge_id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$gelen_sehir_sira = isset($_GET['sehir_sira']) ? intval($_GET['sehir_sira']) : 0;

// Türkiye Geneli Tam Şehir Veri Matrisi (7 Bölge x 7 Şehir)
$tum_sehirler_havuzu = [
    1 => [ // MARMARA BÖLGESİ (id=1)
        0 => [
            'ad' => 'İstanbul', 'bolge' => 'Marmara Bölgesi', 'slogan' => 'İki Kıtayı Birleştiren Dünyanın Başkenti', 'meshur' => 'Tarihi Yarımada, Boğaz Turu, Kız Kulesi, Eminönü Balık Ekmek, Ortaköy Kumpir', 'kapak' => 'images/istanbull.jpg',
            'gezilecekler' => [
                ['baslik' => 'Ayasofya Camii & Sultanahmet Meydanı', 'acıklama' => 'Tarihi Yarımada\'nın kalbi olan bu bölgede binlerce yıllık mimari ihtişamı, Sultanahmet Camii\'ni ve hipodrom dikilitaşlarını görebilirsiniz.'],
                ['baslik' => 'Topkapı Sarayı Müzesi', 'acıklama' => 'Osmanlı padişahlarının yüzyıllarca yönetim merkezi ve evi olan, kutsal emanetlerin ve muazzam Harem dairesinin yer aldığı saray kompleksidir.'],
                ['baslik' => 'Galata Kulesi & İstiklal Caddesi', 'acıklama' => 'Şehre yukarıdan panoramik bakmak için harika bir nokta. Ardından tarihi nostaljik tramvay eşliğinde İstiklal Caddesi boyunca yürüyüş yapın.']
            ],
            'yapilacaklar' => ['Eminönü vapur iskelesinin yanında taze balık-ekmek yiyin.', 'Ortaköy sahilinde boğaz köprüsüne karşı kumpir keyfi yapıp fotoğraf çekilin.', 'Karaköy\'den vapurla Kadıköy\'e geçerek deniz üzerinden kıtalar arası seyahat edin.']
        ],
        1 => [
            'ad' => 'Bursa', 'bolge' => 'Marmara Bölgesi', 'slogan' => 'Osmanlı\'nın İlk Başkenti, Yeşil Bursa', 'meshur' => 'İskender Kebabı, Uludağ, İpek Kumaşları, Kestane Şekeri', 'kapak' => 'images/bursa.jpg',
            'gezilecekler' => [
                ['baslik' => 'Uludağ Milli Parkı', 'acıklama' => 'Türkiye\'nin en popüler kış sporları ve kayak merkezi olan dağ, yaz aylarında da serin kamp alanları sunar.'],
                ['baslik' => 'Cumalıkızık Köyü', 'acıklama' => '700 yıllık erken Osmanlı dönemine ait dokusunu koruyan, rengarenk taş evleri ve dar sokakları olan UNESCO mirası köy.']
            ],
            'yapilacaklar' => ['Bursa merkezinde hakiki tereyağlı Bursa İskender Kebabı yiyin.', 'Şehir merkezinden teleferiğe binerek kesintisiz manzara eşliğinde Uludağ\'a çıkın.']
        ],
        2 => [
            'ad' => 'Edirne', 'bolge' => 'Marmara Bölgesi', 'slogan' => 'Sultanların Şehri, Şehirlerin Sultanı', 'meshur' => 'Selimiye Camii, Tava Ciğeri, Kırkpınar Yağlı Güreşleri', 'kapak' => 'images/edirne.jpg',
            'gezilecekler' => [
                ['baslik' => 'Selimiye Camii', 'acıklama' => 'Mimar Sinan\'ın "ustalık eserim" dediği, devasa kubbesi ve kalem gibi minareleriyle dünya mimarlık tarihinin başyapıtı.'],
                ['baslik' => 'II. Bayezid Külliyesi Sağlık Müzesi', 'acıklama' => 'Osmanlı döneminde akıl hastalarının müzik, su sesi ve güzel kokularla tedavi edildiği tarihi tıp merkezi.']
            ],
            'yapilacaklar' => ['Meşhur Edirne Tava Ciğeri yiyin ve yanında kurutulmuş acı biberi tadın.', 'Tarihi Meriç Köprüsü kenarındaki kafelerde nehir manzarasına karşı çay için.']
        ],
        3 => [
            'ad' => 'Çanakkale', 'bolge' => 'Marmara Bölgesi', 'slogan' => 'Tarihin Yazıldığı Kahramanlar Diyarı', 'meshur' => 'Troya Atı, Şehitlik Anıtı, Assos Antik Kenti, Peynir Helvası', 'kapak' => 'images/çanakkale.jpg',
            'gezilecekler' => [
                ['baslik' => 'Gelibolu Yarımadası Tarihi Alanı', 'acıklama' => 'Çanakkale Savaşları\'nın yaşandığı, Şehitler Abidesi, Conkbayırı ve 57. Alay Şehitliği\'nin yer aldığı manevi atmosferi yüksek bölge.'],
                ['baslik' => 'Troya Antik Kenti ve Müzesi', 'acıklama' => 'Homeros\'un İlyada destanına konu olan efsanevi şehir kalıntıları ve hemen girişinde bulunan devasa sembolik Troya Atı.']
            ],
            'yapilacaklar' => ['Bozcaada\'nın tarihi Rum sokaklarında yürüyün ve Ayazma Plajı\'nda denize girin.', 'Merkezdeki tarihi çarşılardan meşhur Çanakkale Peynir Helvası satın alın.']
        ],
        4 => [
            'ad' => 'Sakarya', 'bolge' => 'Marmara Bölgesi', 'slogan' => 'Doğanın ve Yeşilin Buluştuğu Huzur Rotası', 'meshur' => 'Sapanca Gölü, Islama Köfte, Kabak Tatlısı, Taraklı Evleri', 'kapak' => 'images/sakarya.jpg',
            'gezilecekler' => [
                ['baslik' => 'Sapanca Gölü', 'acıklama' => 'Etrafı yemyeşil ağaçlarla çevrili, yürüyüş yolları, göl kenarı restoranları ve dinlenme alanlarıyla popüler doğa kaçamağı.'],
                ['baslik' => 'Acarlar Longozu (Su Basar Ormanı)', 'acıklama' => 'Türkiye\'nin tek parça en büyük su basar ormanı ekosistemi. Ahşap iskele üzerinde yürüyerek su zambaklarını izleyebilirsiniz.']
            ],
            'yapilacaklar' => ['Sapanca sahil şeridinde bisiklet sürün veya gölde kano turu yapın.', 'Merkezde orijinal Sakarya Islama Köftesi ve üzerine cevizli kabak tatlısı yiyin.']
        ],
        5 => [
            'ad' => 'Tekirdağ', 'bolge' => 'Marmara Bölgesi', 'slogan' => 'Mavi Gözlü Şehir, Trakya\'nın İncisi', 'meshur' => 'Tekirdağ Köftesi, Şarköy Üzüm Bağları, Uçmakdere', 'kapak' => 'images/tekirdag.jpg',
            'gezilecekler' => [
                ['baslik' => 'Uçmakdere Köyü', 'acıklama' => 'Marmara denizine sıfır dik yamaçları, eski ahşap Rum evleri ve asırlık çınarlarıyla doğa ve fotoğraf tutkunlarının gözdesi.'],
                ['baslik' => 'Rakoczi Müzesi', 'acıklama' => 'Macar Prensi II. Frakıo Rakoczi\'nin Tekirdağ\'da sığındığı ve ömrünün son yıllarını geçirdiği tarihi Osmanlı konağı müze.']
            ],
            'yapilacaklar' => ['Uçmakdere yamaç paraşütü alanından atlayarak gökyüzünden denizi izleyin.', 'Sahildeki ünlü lokantalarda porsiyon porsiyon meşhur Tekirdağ Köftesi yiyin.']
        ],
        6 => [
            'ad' => 'Kocaeli', 'bolge' => 'Marmara Bölgesi', 'slogan' => 'Sanayinin Kalbindeki Doğa Cenneti', 'meshur' => 'Kartepe Kayak Merkezi, Pişmaniye, Maşukiye Şelaleleri', 'kapak' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1600',
            'gezilecekler' => [
                ['baslik' => 'Kartepe Zirvesi', 'acıklama' => 'Samanlı Dağları\'nın en yüksek noktası olan, kışın kar kalitesi yüksek pistleri, yazın ise yayla havası sunan turizm merkezi.'],
                ['baslik' => 'Maşukiye Şelaleleri', 'acıklama' => 'Yemyeşil ormanların içinden akan küçük dereleri, şelaleleri ve doğa yürüyüş yolları bulunan huzurlu bir vadi alanı.']
            ],
            'yapilacaklar' => ['Maşukiye\'deki ahşap restoranlarda kiremitte alabalık yiyin.', 'Kocaeli\'den ayrılmadan önce taze çekilmiş tel tel Pişmaniye satın alın.']
        ]
    ],
    2 => [ // İÇ ANADOLU BÖLGESİ (id=2)
        0 => [
            'ad' => 'Ankara', 'bolge' => 'İç Anadolu Bölgesi', 'slogan' => 'Cumhuriyetimizin Kalbi ve Başkenti', 'meshur' => 'Anıtkabir, Ankara Kalesi, Ankara Tavası, Hamamönü', 'kapak' => 'images/ankara.jpg',
            'gezilecekler' => [
                ['baslik' => 'Anıtkabir', 'acıklama' => 'Gazi Mustafa Kemal Atatürk\'ün anıt mezarı. Aslanlı Yol, Tören Meydanı ve Kurtuluş Savaşı Müzesi ile manevi değeri en yüksek yerdir.'],
                ['baslik' => 'Ankara Kalesi', 'acıklama' => 'Tarihi Hititlere kadar uzanan, içindeki eski Ankara evleri, antik dükkanları ve şehri kuş bakışı gören surlarıyla ünlü kale.']
            ],
            'yapilacaklar' => ['Restore edilmiş tarihi Hamamönü sokaklarında yürüyüp kumda kahve için.', 'Yöresel pirinç ve etle fırında pişen nefis Ankara Tavası yiyin.']
        ],
        1 => [
            'ad' => 'Nevşehir', 'bolge' => 'İç Anadolu Bölgesi', 'slogan' => 'Masalsı Güzel Atlar Ülkesi, Kapadokya', 'meshur' => 'Peri Bacaları, Sıcak Hava Balonları, Yer Altı Şehirleri, Testi Kebabı', 'kapak' => 'images/nevsehir.jpg',
            'gezilecekler' => [
                ['baslik' => 'Göreme Açık Hava Müzesi', 'acıklama' => 'Kaya bloklarının içine oyulmuş kiliseler, şapeller ve manastırlardan oluşan muazzam bir Hristiyanlık tarihi merkezi.'],
                ['baslik' => 'Derinkuyu Yer Altı Şehri', 'acıklama' => 'Binlerce insanın istila zamanlarında aylarca dışarı çıkmadan yerin altında yaşayabildiği odalar, ahırlar ve tüneller kompleksi.']
            ],
            'yapilacaklar' => ['Gün doğumunda havalanan rengarenk sıcak hava balonlarına binin veya vadilerden izleyin.', 'Avanos\'taki tarihi çömlek atölyelerinde çamura kendiniz şekil verin.']
        ],
        2 => [
            'ad' => 'Konya', 'bolge' => 'İç Anadolu Bölgesi', 'slogan' => 'Gönüller Diyarı, Hz. Mevlana Şehri', 'meshur' => 'Mevlana Müzesi, Etli Ekmek, Şeb-i Arus Törenleri', 'kapak' => 'images/konya.jpg',
            'gezilecekler' => [
                ['baslik' => 'Mevlana Müzesi ve Dergahı', 'acıklama' => 'Hz. Mevlana\'nın türbesinin (Yeşil Kubbe) yer aldığı, derviş odaları ve el yazması eserlerin sergilendiği mistik alan.'],
                ['baslik' => 'Sille Antik Köyü', 'acıklama' => 'Tarihi Roma dönemine kadar uzanan, kaya oyma tapınakları ve restore edilmiş taş kiliseleri barındıran sessiz köy.']
            ],
            'yapilacaklar' => ['Boyu bir metreyi bulan incecik çıtır çıtır Konya Etli Ekmeği yiyin.', 'Tarihi Tropikal Kelebek Bahçesi\'nde binlerce uçuşan kelebeği görün.']
        ],
        3 => [
            'ad' => 'Eskişehir', 'bolge' => 'İç Anadolu Bölgesi', 'slogan' => 'Anadolu\'nun Modern, Canlı ve Kültür Şehri', 'meshur' => 'Porsuk Çayı, Odunpazarı Evleri, Çibörek, Lületaşı', 'kapak' => 'images/eskisehir.webp',
            'gezilecekler' => [
                ['baslik' => 'Odunpazarı Tarihi Evleri', 'acıklama' => 'Rengarenk boyalı, ahşap süslemeli Osmanlı dönemi evlerinin korunduğu, aralarında modern müzelerin de olduğu sokaklar.'],
                ['baslik' => 'Sazova Bilim Sanat ve Kültür Parkı', 'acıklama' => 'İçinde devasa bir Masal Şatosu, Korsan Gemisi, Uzay Evi ve Akvaryum barındıran Türkiye\'nin en yaratıcı parklarından biri.']
            ],
            'yapilacaklar' => ['Porsuk Çayı (Adalar) üzerinde Venedik usulü gondollarla keyifli tura çıkın.', 'Kafelerde içi sıcak kıyma dolgulu, pofuduk Eskişehir Çiböreği yiyin.']
        ],
        4 => [
            'ad' => 'Kayseri', 'meshur' => 'Erciyes Dağı, Kayseri Mantısı, Pastırma', 'yapilacak' => 'Erciyes Kayak Merkezi\'nde kış sporları yap, tarihi Kapalı Çarşı\'dan alışveriş yap.', 'foto' => 'images/kayseri.webp',
            'bolge' => 'İç Anadolu Bölgesi', 'slogan' => 'Erciyes\'in Gölgesinde Ticaret ve Lezzet Başkenti', 'kapak' => 'images/kayseri.webp',
            'gezilecekler' => [
                ['baslik' => 'Erciyes Kayak Merkezi', 'acıklama' => 'Sönmüş bir volkan olan Erciyes Dağı üzerinde kurulu dünya standartlarında kış sporları tesisi.'],
                ['baslik' => 'Kayseri Kalesi', 'acıklama' => 'Roma döneminden kalan, kesme taş mimarisiyle şehir meydanında devasa bir anıt gibi duran kale.']
            ],
            'yapilacaklar' => ['Bir kaşığa 40 tane sığdığı söylenen minik Kayseri Mantısı yiyin.', 'Pastırmacılar Çarşısı\'ndan çemenli hakiki Kayseri pastırması satın alın.']
        ],
        5 => [
            'ad' => 'Sivas', 'bolge' => 'İç Anadolu Bölgesi', 'slogan' => 'Selçuklu Eserleri ve Selçuklu Mirası Kadim Kent', 'meshur' => 'Divriği Ulu Camii, Sivas Köftesi, Gök Medrese', 'kapak' => 'images/images (1).jpg',
            'gezilecekler' => [
                ['baslik' => 'Divriği Ulu Camii ve Darüşşifası', 'acıklama' => 'UNESCO Dünya Mirası listesinde yer alan, üzerindeki taş oyma figürlerin muazzamlığıyla büyüleyen Selçuklu şaheseri.'],
                ['baslik' => 'Gök Medrese ve Çifte Minare', 'acıklama' => 'Şehir merkezinde bulunan, mavi çinileri ve devasa taç kapıları ile ünlü Selçuklu eğitim kurumları kalıntıları.']
            ],
            'yapilacaklar' => ['Katkısız sadece et ve tuzla yapılan incecik nefis Sivas Köftesi yiyin.', 'Kangal ilçesine giderek dünyaca ünlü sadık Kangal köpeklerini yerinde görün.']
        ],
        6 => [
            'ad' => 'Aksaray', 'bolge' => 'İç Anadolu Bölgesi', 'slogan' => 'Kanyonlar ve Medeniyetlerin Geçiş Kapısı', 'meshur' => 'Ihlara Vadisi, Eğri Minare, Selime Manastırı', 'kapak' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=1600',
            'gezilecekler' => [
                ['baslik' => 'Ihlara Vadisi', 'acıklama' => 'Hasan Dağı volkanından akan lavların aşındırmasıyla oluşan, Melendiz çayının aktığı ve dik kayalara oyulmuş onlarca kilisenin olduğu 14 kilometrelik dev kanyon.'],
                ['baslik' => 'Selime Katedrali', 'acıklama' => 'Ihlara vadisinin bitiş noktasında yer alan, kaya içine oyulmuş devasa büyüklükteki ilk Hristiyan katedral yapısı.']
            ],
            'yapilacaklar' => ['Ihlara vadisinin tabanındaki Melendiz çayı üzerine kurulu çardaklarda ayaklarınızı suya uzatarak çay için.', 'Şehir merkezindeki Selçuklu mirası kırmızı tuğlalı Eğri Minare\'yi fotoğraflayın.']
        ]
    ],
    3 => [ // EGE BÖLGESİ (id=3)
        0 => [
            'ad' => 'İzmir', 'bolge' => 'Ege Bölgesi', 'slogan' => 'Ege\'nin İncisi, Özgürlük ve Tarih Kokan Şehir', 'meshur' => 'Saat Kulesi, Kordon Boyu, Efes Antik Kenti, Boyoz, Kemeraltı', 'kapak' => 'images/indir.jpg',
            'gezilecekler' => [
                ['baslik' => 'Efes Antik Kenti (Selçuk)', 'acıklama' => 'Dünyanın en iyi korunmuş Roma kentlerinden biri. Celsus Kütüphanesi, Antik Tiyatro ve Hadriyan Tapınağı büyüleyicidir.'],
                ['baslik' => 'Konak Saat Kulesi & Tarihi Asansör', 'acıklama' => 'İzmir\'in simgesi olan asırlık saat kulesi ve iki caddeyi birleştiren körfez manzaralı tarihi asansör binası.']
            ],
            'yapilacaklar' => ['Sabah erkenden Kemeraltı çarşısında taze pişmiş Boyoz ve haşlanmış yumurta yiyin.', 'Alsancak Kordon boyunda çimlere oturup körfeze karşı gün batımını izleyin.']
        ],
        1 => [
            'ad' => 'Muğla', 'bolge' => 'Ege Bölgesi', 'slogan' => 'Eşsiz Koylar ve Turizmin Dünya Markası', 'meshur' => 'Bodrum Kalesi, Fethiye Ölüdeniz, Marmaris, Kelebekler Vadisi', 'kapak' => 'images/mugla.jpg',
            'gezilecekler' => [
                ['baslik' => 'Fethiye Ölüdeniz', 'acıklama' => 'Durgun suyu ve bembeyaz kumsalıyla dünyanın en güzel lagünlerinden biri olarak kabul edilen plaj alanı.'],
                ['baslik' => 'Bodrum Kalesi ve Sualtı Arkeoloji Müzesi', 'acıklama' => 'St. Jean şövalyeleri tarafından yapılan, içinde batık gemi kalıntılarının sergilendiği görkemli kale.']
            ],
            'yapilacaklar' => ['Fethiye Babadağ\'dan yamaç paraşütüyle atlayarak Ölüdeniz manzarasını gökyüzünden izleyin.', 'Marmaris veya Göcek kalkışlı günübirlik ahşap tekne turlarına katılarak bakir koyları gezin.']
        ],
        2 => [
            'ad' => 'Aydın', 'bolge' => 'Ege Bölgesi', 'slogan' => 'Gökyüzünün Altındaki En Güzel Yer', 'meshur' => 'Kuşadası, Didim Apollon Tapınağı, İncir, zeytinyağlılar', 'kapak' => 'images/aydin.webp',
            'gezilecekler' => [
                ['baslik' => 'Didim Apollon Tapınağı', 'acıklama' => 'Antik dünyanın en büyük kehanet merkezlerinden biri olan, devasa sütunları ve Medusa başı kabartmasıyla ünlü tapınak kalıntısı.'],
                ['baslik' => 'Dilek Yarımadası Milli Parkı', 'acıklama' => 'Kuşadası sınırlarında, ormanın yeşili ile denizin mavisinin birleştiği, yaban domuzlarının sahile indiği doğal cennet.']
            ],
            'yapilacaklar' => ['Kuşadası Güvercinada Kalesi\'ni yürüyerek gezin ve sahilinde yürüyüş yapın.', 'Yaz mevsiminde dalından koparılmış taze Aydın İnciri yiyin.']
        ],
        3 => [
            'ad' => 'Denizli', 'bolge' => 'Ege Bölgesi', 'slogan' => 'Beyaz Cennet Travertenler Şehri', 'meshur' => 'Pamukkale Travertenleri, Hierapolis Antik Kenti, Denizli Kebabı', 'kapak' => 'images/denizli.jpg',
            'gezilecekler' => [
                ['baslik' => 'Pamukkale Travertenleri', 'acıklama' => 'Kalsiyum oksitli şifalı termal suların oluşturduğu, pamuk gibi görünen dünyaca ünlü beyaz kalker teras havuzları.'],
                ['baslik' => 'Hierapolis Antik Havuz (Kleopatra)', 'acıklama' => 'Deprem sonucu antik sütunların suyun içine yıkılmasıyla oluşan, yaz-kış 36 derece olan şifalı tarihi havuz.']
            ],
            'yapilacaklar' => ['Travertenlerin beyaz zemininde çıplak ayakla yürüyerek şifalı suların tadını çıkarın.', 'Çatal kullanılmadan elle yenen meşhur fırın pişmesi Denizli Kebabı yiyin.']
        ],
        4 => [
            'ad' => 'Manisa', 'bolge' => 'Ege Bölgesi', 'slogan' => 'Şehzadeler Şehri ve Spil Dağı Efsaneleri', 'meshur' => 'Mesir Macunu, Sultaniye Üzümü, Spil Dağı Yılkı Atları', 'kapak' => 'images/manisa.jpg',
            'gezilecekler' => [
                ['baslik' => 'Spil Dağı Milli Parkı', 'acıklama' => 'Kanyonları, mağaraları, endemik Manisa laleleri ve özgürce koşan vahşi yılkı atlarıyla ünlü büyük dağ kitlesi.'],
                ['baslik' => 'Sardes Antik Kenti (Salihli)', 'acıklama' => 'Tarihte parayı ilk bulan Lidya krallığının başkenti. Devasa gymnasium yapısı ve antik sinagogu görülmeye değerdir.']
            ],
            'yapilacaklar' => ['Nisan ayında tarihi Sultan Camii kubbelerinden saçılan şifalı Mesir Macunu Festivali\'ne katılın.', 'Dünyaca ünlü çekirdeksiz kurutulmuş Sultaniye Üzümü satın alın.']
        ],
        5 => [
            'ad' => 'Afyonkarahisar', 'bolge' => 'Ege Bölgesi', 'slogan' => 'Termal Kaplıcalar ve Lezzetin Kesişim Noktası', 'meshur' => 'Afyon Kaymağı, Afyon Sucuğu, Termal Oteller, Afyon Kalesi', 'kapak' => 'images/afyon.jpg',
            'gezilecekler' => [
                ['baslik' => 'Tarihi Afyonkarahisar Kalesi', 'acıklama' => 'Şehrin tam ortasında yükselen 226 metre yükseklikteki volkanik kaya kütlesinin zirvesine kurulu, tırmanması zahmetli ama manzarası harika kale.'],
                ['baslik' => 'Frig Vadisi Kalıntıları', 'acıklama' => 'Kaya mezarları, anıt abideleri ve peri bacalarıyla Kapadokya\'yı andıran tarihi Frigya yerleşim alanı.']
            ],
            'yapilacaklar' => ['Şifalı mineralli sulara sahip 5 yıldızlı lüks termal otellerin havuzlarında yenilenin.', 'Manda sütünden üretilen taze Afyon Kaymağı eşliğinde ekmek kadayıfı tatlısı yiyin.']
        ],
    ],
    4 => [ // AKDENİZ BÖLGESİ (id=4)
        0 => [
            'ad' => 'Antalya', 'bolge' => 'Akdeniz Bölgesi', 'slogan' => 'Türk Rivierası, Dünya Turizminin Başkenti', 'meshur' => 'Kaleiçi, Düden Şelalesi, Olimpos Plajı, Antalya Piyazı', 'kapak' => 'images/antalya.jpg',
            'gezilecekler' => [
                ['baslik' => 'Tarihi Kaleiçi', 'acıklama' => 'Hadrian Kapısı (Üçkapılar) ile girilen, dar taş sokakları, eski Osmanlı konakları ve antik limanı olan yaşayan tarih merkezi.'],
                ['baslik' => 'Aspendos Antik Tiyatrosu', 'acıklama' => 'Romalılardan kalan, günümüze kadar akustiği ve sahne binası hiç bozulmadan gelebilmiş dünyanın en ünlü antik tiyatrosu.']
            ],
            'yapilacaklar' => ['Denize dökülen devasa Düden Şelalesi\'nin parkında yürüyüş yapın.', 'Tahinli ve sarımsaklı özel Antalya Piyazı eşliğinde köfte yiyin.']
        ],
        1 => [
            'ad' => 'Adana', 'bolge' => 'Akdeniz Bölgesi', 'slogan' => 'Güneşin, Festivallerin ve Gurme Lezzetlerin Şehri', 'meshur' => 'Adana Kebabı, Şalgam Suyu, Tarihi Taşköprü, Sabancı Merkez Camii', 'kapak' => 'images/adana.jpg',
            'gezilecekler' => [
                ['baslik' => 'Tarihi Taşköprü', 'acıklama' => 'Seyhan Nehri üzerinde kurulu, Romalılardan kalan ve dünyada hala aktif olarak kullanılan en eski taş köprü kenti simgesi.'],
                ['baslik' => 'Sabancı Merkez Camii', 'acıklama' => '6 minaresi ve devasa kubbesi ile Seyhan nehrinin kıyısında tüm ihtişamıyla yükselen Balkanların ve Ortadoğu\'nun en büyük camilerinden biri.']
            ],
            'yapilacaklar' => ['Seyhan nehir kenarında kuşbaşı veya zırh kıymasından yapılmış bol mezeli Adana Kebabı yiyin.', 'Sıcak havalarda bici bici adı verilen buzlu nişastalı yerel tatlıyı deneyin.']
        ],
        2 => [
            'ad' => 'Mersin', 'bolge' => 'Akdeniz Bölgesi', 'slogan' => 'Palmiyeler Altında Uzanan Akdeniz Sahili', 'meshur' => 'Mersin Tantunisi, Kızkalesi, Cennet-Cehennem Obrukları, Cezerye', 'kapak' => 'images/mersin.jpg',
            'gezilecekler' => [
                ['baslik' => 'Kızkalesi (Deniz Kalesi)', 'acıklama' => 'Kıyıdan 200 metre açıkta, denizin tam ortasındaki küçük bir ada üzerine inşa edilmiş efsanelere konu olan tarihi kale.'],
                ['baslik' => 'Cennet ve Cehennem Çökükleri', 'acıklama' => 'Yeraltı sularının erozyonuyla oluşan iki devasa doğal obruk çöküntüsü. Cennet obruğunun dibinde tarihi bir kilise ve akarsu bulunur.']
            ],
            'yapilacaklar' => ['Mersin marinasında deniz havası alarak incecik lavaşa sarılı bol limonlu Mersin Tantunisi yiyin.', 'Havuç ve cevizden yapılan enerji deposu cezerye tatlısından satın alın.']
        ],
        3 => [
            'ad' => 'Hatay', 'bolge' => 'Akdeniz Bölgesi', 'slogan' => 'Medeniyetlerin Kardeşçe Yaşadığı Hoşgörü Şehri', 'meshur' => 'Hatay Künefesi, Antakya Arkeoloji Müzesi, Kağıt Kebabı', 'kapak' => 'images/hatay.jpg',
            'gezilecekler' => [
                ['baslik' => 'Hatay Mozaik Müzesi', 'acıklama' => 'Roma ve Bizans dönemine ait, dünyaca ünlü ve alanında dünyanın en büyük zengin antik mozaik koleksiyonuna sahip modern müze.'],
                ['baslik' => 'St. Pierre Kilisesi', 'acıklama' => 'Hristiyanlık kelimesinin dünyada ilk kez kullanıldığı, dağ eteğine oyulmuş dünyanın ilk mağara kilisesi kabul edilen kutsal alan.']
            ],
            'yapilacaklar' => ['Tarihi çarşıda közde pişen, sıcak şerbetli ve içi uzayan künefe peynirli Hatay Künefesi yiyin.', 'Antakya uzun çarşı sokaklarında tarihi baharatçıları ve sabuncuları gezin.']
        ],
        4 => [
            'ad' => 'Kahramanmaraş', 'bolge' => 'Akdeniz Bölgesi', 'slogan' => 'İstiklal Madalyalı, Dondurmanın Ana Vatanı', 'meshur' => 'Maraş Dondurması, Tarhana, Yeşilgöz Obruğu', 'kapak' => 'images/kahramanmaras.jpg',
            'gezilecekler' => [
                ['baslik' => 'Tarihi Kahramanmaraş Kalesi', 'acıklama' => 'Şehrin tam merkezindeki tepeye kurulu, milli mücadelenin bayrak olayının yaşandığı tarihi park ve kale alanı.'],
                ['baslik' => 'Yeşilgöz Obruğu / Başkonuş Yaylası', 'acıklama' => 'Derinliği tam bilinmeyen, zümrüt yeşili rengiyle büyüleyen doğal su kaynağı havzası ve geyiklerin gezdiği yayla ormanı.']
            ],
            'yapilacaklar' => ['Keçi sütü ve salepten yapılan, satırla kesilerek yenen meşhur Maraş Dondurması yiyin.', 'Çorbası da yapılan kuru cips şeklindeki Maraş Tarhanasını tadın.']
        ],
        5 => [
            'ad' => 'Isparta', 'bolge' => 'Akdeniz Bölgesi', 'slogan' => 'Güllerin ve Lavantaların Mis Kokulu Şehri', 'meshur' => 'Isparta Gülü, Lavanta Kokulu Köy (Kuyucak), Eğirdir Gölü', 'kapak' => 'images/isparta.jpg',
            'gezilecekler' => [
                ['baslik' => 'Kuyucak Lavanta Köyü', 'acıklama' => 'Temmuz ayında açan lavantalarla tüm köyün mora boyandığı, sokaklarından mis gibi lavanta kokusu yükselen turizm köyü.'],
                ['baslik' => 'Eğirdir Gölü ve Can Ada', 'acıklama' => 'Türkiye\'nin dördüncü büyük gölü. İçine doğru uzanan yarımadası, kuş gözlem alanları ve temiz plajlarıyla sakin bir doğa alanı.']
            ],
            'yapilacaklar' => ['Mayıs-Haziran döneminde sabah erkenden gül bahçelerinde kozmetik amaçlı gül hasadına katılın.', 'Doğal gül suyu ve gül kremi ürünlerinden kendinize hediye alın.']
        ],
    ],
    5 => [ // KARADENİZ BÖLGESİ (id=5)
        0 => [
            'ad' => 'Trabzon', 'bolge' => 'Karadeniz Bölgesi', 'slogan' => 'Tarihin ve Yeşilin Karadeniz Sahilindeki Kalesi', 'meshur' => 'Sümela Manastırı, Uzungöl, Akçaabat Köftesi, Mıhlama (Kuymak)', 'kapak' => 'images/trabzon.jpg',
            'gezilecekler' => [
                ['baslik' => 'Sümela Manastırı', 'acıklama' => 'Altındere vadisindeki sarp kaya kütlesine oyularak inşa edilmiş, yerden yüzlerce metre yükseklikteki dünyaca ünlü tarihi Rum manastırı.'],
                ['baslik' => 'Uzungöl Tabiat Parkı', 'acıklama' => 'Dağların arasına sıkışmış, etrafı dik çam ormanlarıyla kaplı, ortasında cami ve göl olan kartpostallık turizm merkezi.']
            ],
            'yapilacaklar' => ['Trabzon yaylalarında mısır unu, tereyağı ve kolot peyniriyle uzayan sıcak Kuymak (Mıhlama) yiyin.', 'Akçaabat ilçesinde sahil kenarında meşhur sarımsaklı Akçaabat Köftesi yiyin.']
        ],
        1 => [
            'ad' => 'Rize', 'bolge' => 'Karadeniz Bölgesi', 'slogan' => 'Bulut Denizleri ve Çay Bahçelerinin Eşsiz Zirvesi', 'meshur' => 'Ayder Yaylası, Rize Çayı, Fırtına Deresi, Pokut Yaylası', 'kapak' => 'images/rize.jpg',
            'gezilecekler' => [
                ['baslik' => 'Ayder ve Pokut Yaylaları', 'acıklama' => 'Kaçkar dağlarının eteklerinde yer alan, ahşap yayla evleri ve ayaklarınızın altına serilen sis bulutlarıyla ünlü doğa cennetleri.'],
                ['baslik' => 'Zil Kale', 'acıklama' => 'Fırtına vadisinde, sarp bir kaya üzerine kurulu, dere yatağından yüzlerce metre yüksekte olan korunaklı tarihi orta çağ kalesi.']
            ],
            'yapilacaklar' => ['Fırtına Deresi üzerindeki tarihi taş köprüleri fotoğraflayın, nehirde rafting veya zipline yapın.', 'İnce belli camgöbeğinde taze demlenmiş Rize çayı için.']
        ],
        2 => [
            'ad' => 'Samsun', 'bolge' => 'Karadeniz Bölgesi', 'slogan' => 'Milli Mücadelenin ve İlk Adımın Atıldığı Şehir', 'meshur' => 'Bandırma Vapuru, Atatürk Anıtı, Bafra Pidesi', 'kapak' => 'images/samsun.jpg',
            'gezilecekler' => [
                ['baslik' => 'Bandırma Vapuru Müzesi', 'acıklama' => 'Atatürk ve silah arkadaşlarını 19 Mayıs 1919\'da Samsun\'a getiren vapurun birebir ölçülerindeki müze hali ve balmumu heykelleri.'],
                ['baslik' => 'Şahinkaya Kanyonu (Vezirköprü)', 'acıklama' => 'Kızılırmak üzerinde yer alan, metrelerce yükseklikteki dik kaya duvarların arasından geçen Türkiye\'nin en uzun kanyonlarından biri.']
            ],
            'yapilacaklar' => ['Şahinkaya kanyonunda motorlu teknelerle geziye çıkıp dev kayaları fotoğraflayın.', 'Çıtır ve uzun kapalı kıymalı pazar klasiği olan Bafra Pidesi yiyin.']
        ],
        3 => [
            'ad' => 'Ordu', 'bolge' => 'Karadeniz Bölgesi', 'slogan' => 'Derelerin Şehri, Boztepe\'den Karadeniz Seyri', 'meshur' => 'Boztepe Teleferik, Ordu Fındığı, Yason Burnu Kilisesi', 'kapak' => 'images/ordu.jpg',
            'gezilecekler' => [
                ['baslik' => 'Boztepe', 'acıklama' => 'Şehrin hemen arkasında yükselen, modern teleferik hattıyla çıkılan ve Ordu sahilini, denizi ayaklar altına seren seyir terası tepesi.'],
                ['baslik' => 'Yason Burnu Yarımadası', 'acıklama' => 'Argonotlar efsanesinin geçtiği, üzerinde tarihi küçük taş bir Rum kilisesi olan denize doğru uzanan sakin burun alanı.']
            ],
            'yapilacaklar' => ['Şehir merkezinden teleferiğe binerek türkülere konu olan Boztepe\'ye çıkıp manzara eşliğinde çay için.', 'Dünyanın en kaliteli taze Ordu Fındıklarından satın alın.']
        ],
        4 => [
            'ad' => 'Amasya', 'bolge' => 'Karadeniz Bölgesi', 'slogan' => 'Yeşilırmak Kenarında Tarih Yazan Şehzadeler Şehri', 'meshur' => 'Kral Kaya Mezarları, Amasya Elması, Yalıboyu Evleri', 'kapak' => 'images/amasya.jpg',
            'gezilecekler' => [
                ['baslik' => 'Kral Kaya Mezarları', 'acıklama' => 'Amasya kalesinin eteklerindeki dev kalker kayalara oyularak yapılmış, Pontus krallarına ait olan geceleri ışıklandırılan anıt mezarlar.'],
                ['baslik' => 'Yalıboyu Osmanlı Evleri', 'acıklama' => 'Yeşilırmak nehrinin kenarına bitişik dizilmiş, sur duvarları üzerine kurulu, ahşap cumbalı beyaz boyalı tarihi konaklar şeridi.']
            ],
            'yapilacaklar' => ['Irmak kenarındaki Şehzadeler Gezi Yolu\'nda yürüyüş yapıp nehir üzerindeki kuğuları izleyin.', 'Sert, sulu ve kokulu minik Amasya Elması tadın.']
        ],
        5 => [
            'ad' => 'Sinop', 'bolge' => 'Karadeniz Bölgesi', 'slogan' => 'Türkiye\'nin En Kuzey Ucu, Mutlu İnsanlar Şehri', 'meshur' => 'Tarihi Sinop Cezaevi, Hamsilos Koyu, Sinop Mantısı', 'kapak' => 'images/sinop.jpg',
            'gezilecekler' => [
                ['baslik' => 'Tarihi Sinop Cezaevi', 'acıklama' => 'Üç yanı denizle çevrili surların içinde yer alan, Sabahattin Ali gibi ünlü isimlerin hapis yattığı, filmlere konu olmuş "Anadolu\'nun Alkatrazı" müze cezaevi.'],
                ['baslik' => 'Hamsilos Koyu (Fiyord)', 'acıklama' => 'Buzul aşındırması sonucu oluşmuş, denizin ormanın içine doğru kıvrılarak girdiği Türkiye\'nin tek fiyordu kabul edilen doğa harikası koy.']
            ],
            'yapilacaklar' => ['Türkiye\'nin en kuzey uç noktası olan İnceburun Feneri\'ne giderek azgın dalgaları izleyin.', 'Yarısı cevizli yarısı sarımsak yoğurtlu olarak servis edilen meşhur Sinop Mantısı yiyin.']
        ],
      
    ],
    6 => [ // DOĞU ANADOLU BÖLGESİ (id=6)
        0 => [
            'ad' => 'Erzurum', 'bolge' => 'Doğu Anadolu Bölgesi', 'slogan' => 'Dadaşlar Diyarı, Palandöken Dağı etekleri', 'meshur' => 'Palandöken Kayak Merkezi, Cağ Kebabı, Çifte Minareli Medrese', 'kapak' => 'images/erzurum.jpg',
            'gezilecekler' => [
                ['baslik' => 'Palandöken Kayak Merkezi', 'acıklama' => 'Türkiye\'nin en uzun ve dik pistlerine sahip, kış turizminin uluslararası ölçekteki gözde dağ tesisleri kompleksi.'],
                ['baslik' => 'Çifte Minareli Medrese', 'acıklama' => 'Selçuklular döneminden kalan, anıtsal taç kapısı ve üzerindeki bitki motifli taş işlemeleriyle Erzurum\'un ana simgesi olan medrese yapısı.']
            ],
            'yapilacaklar' => ['Yatık döner şeklinde odun ateşinde pişen, şişlere takılarak servis edilen meşhur Erzurum Cağ Kebabı yiyin.', 'Tarihi Taşhan (Rüstem Paşa Kervansarayı) çarşısından el işi siyah Oltu Taşı tespih veya takı satın alın.']
        ],
        1 => [
            'ad' => 'Van', 'bolge' => 'Doğu Anadolu Bölgesi', 'slogan' => 'Güneşin Doğduğu Urartu Başkenti', 'meshur' => 'Van Gölü (Denizi), Akdamar Adası, Van Kedisi, Meşhur Van Kahvaltısı', 'kapak' => 'images/van.jpg',
            'gezilecekler' => [
                ['baslik' => 'Akdamar Adası ve Kilisesi', 'acıklama' => 'Van Gölü üzerinde motorlarla geçilen, üzerinde Orta Çağ Ermeni mimarisinin en şık taş kabartma duvarlı kilisesini barındıran badem ağaçlarıyla süslü ada.'],
                ['baslik' => 'Tarihi Van Kalesi', 'acıklama' => 'Urartu krallığı tarafından sarp kayalıklar üzerine inşa edilen, içinde Urartu krallarının kaya mezarlarının ve çivi yazılı kitabelerinin olduğu dev kale.']
            ],
            'yapilacaklar' => ['Göl kenarındaki otantik restoranlarda onlarca çeşit organik üründen oluşan meşhur Van Kahvaltısı yapın.', 'Yüzüncü Yıl Üniversitesi kedi evine giderek bir gözü mavi bir gözü yeşil olan Van Kedilerini sevin.']
        ],
        2 => [
            'ad' => 'Kars', 'bolge' => 'Doğu Anadolu Bölgesi', 'slogan' => 'Karlar Altındaki Sınır Şehri, Baltık Mimarisi', 'meshur' => 'Ani Antik Kenti, Kars Kaşarı, Çıldır Gölü Atlı Kızakları, Kars Kazı', 'kapak' => 'images/kars.jpg',
            'gezilecekler' => [
                ['baslik' => 'Ani Arkeolojik Alanı (Harabeleri)', 'acıklama' => 'Türkiye-Ermenistan sınırında yer alan, yüzyıllar önce ipek yolu üzerinde kurulan, binbir kiliseli şehir olarak bilinen UNESCO tescilli dev antik metropol kalıntıları.'],
                ['baslik' => 'Kars Rus Baltık Mimarisi Evleri', 'acıklama' => 'Rus işgali döneminde taştan ızgara planlı inşa edilen, günümüzde otel ve kamu binası olarak kullanılan dik çatılı siyah bazalt taş binalar caddesi.']
            ],
            'yapilacaklar' => ['Kış mevsiminde tamamen donan Çıldır Gölü üzerinde atlı kızaklara binip, buzları kırarak sarı balık avlayanları izleyin.', 'Geleneksel yöntemle pişirilen meşhur fırınlanmış Kars Kaz Eti yiyin.']
        ],
        3 => [
            'ad' => 'Ağrı', 'bolge' => 'Doğu Anadolu Bölgesi', 'slogan' => 'Efsanevi Dağın ve Masalsı Sarayın Diyarı', 'meshur' => 'Ağrı Dağı, İshak Paşa Sarayı, Meteor Çukuru', 'kapak' => 'images/agri.jpg',
            'gezilecekler' => [
                ['baslik' => 'İshak Paşa Sarayı (Doğubayazıt)', 'acıklama' => 'Ova ortasındaki bir tepe üzerinde yükselen, Selçuklu, Osmanlı ve Barok mimarisinin karışımı olan, dünyanın ilk kalorifer sistemli saray kompleksi kabul edilen sanat harikası.'],
                ['baslik' => 'Ağrı Dağı Milli Parkı', 'acıklama' => '5137 metre yüksekliğiyle Türkiye\'nin ve Avrupa\'nın en yüksek zirvesi olan, Nuh\'un gemisi efsanesine ev sahipliği yapan devasa buzul dağ alanı.']
            ],
            'yapilacaklar' => ['İshak Paşa Sarayı\'nın dev taç kapısı önünde gün batımı fotoğrafı çekilin.', 'Doğubayazıt ilçesinde yapılan tescilli et yemeği Abdigör Köftesi\'ni tadın.']
        ],
        4 => [
            'ad' => 'Erzincan', 'bolge' => 'Doğu Anadolu Bölgesi', 'slogan' => 'Doğa Sporlarının ve Kanyonların Merkezi', 'meshur' => 'Erzincan Tulum Peyniri, Karanlık Kanyon, Girlevik Şelalesi', 'kapak' => 'images/erzincan.jpg',
            'gezilecekler' => [
                ['baslik' => 'Kemaliye Karanlık Kanyon', 'acıklama' => 'Dünyanın en derin ve tehlikeli kanyonlarından biri. İki tarafı dik yüzlerce metrelik taş duvarlardan oluşan ve elle oyulan Taş Yol projesini barındıran doğa harikası.'],
                ['baslik' => 'Girlevik Şelalesi', 'acıklama' => 'Birkaç kattan akan suları, etrafındaki yemyeşil mesire alanıyla yazın serinlik veren, kışın ise tamamen buz sarkıtlarına dönen ünlü şelale.']
            ],
            'yapilacaklar' => ['Karanlık kanyonda macera dolu hızlı bot turlarına veya kano aktivitelerine katılın.', 'Kahvaltılarda tüketilen hakiki koyun sütü deride basma Erzincan Tulum Peyniri satın alın.']
        ],
        5 => [
            'ad' => 'Malatya', 'bolge' => 'Doğu Anadolu Bölgesi', 'slogan' => 'Dünyanın Kayısı Ambarı, Arkeoloji Tarihi', 'meshur' => 'Malatya Kayısısı, Arslantepe Höyüğü, Analı Kızlı Çorbası', 'kapak' => 'images/malatya.jpg',
            'gezilecekler' => [
                ['baslik' => 'Arslantepe Höyüğü', 'acıklama' => 'UNESCO Dünya Mirası listesinde yer alan, insanlık tarihinin ilk kerpiç saray yapısının ve ilk bürokrasi mühürlerinin bulunduğu kerpiç antik kent alanı.'],
                ['baslik' => 'Levent Vadisi', 'acıklama' => '65 milyon yıl öncesine dayanan kaya oluşumları, mağaraları ve üzerinde uçuruma uzanan çelik tabanlı cam seyir terası olan büyük vadi.']
            ],
            'yapilacaklar' => ['Yaz aylarında uçsuz bucaksız Malatya Kayısı bahçelerini gezip dalından sarı kayısı yiyin.', 'Tarihi Şire Pazarı\'ndan gün kurusu kayısı, pestil ve muska satın alın.']
        ],
       
    ],
    7 => [ // GÜNEYDOĞU ANADOLU BÖLGESİ (id=7)
        0 => [
            'ad' => 'Şanlıurfa', 'bolge' => 'Güneydoğu Anadolu Bölgesi', 'slogan' => 'Peygamberler Şehri, Tarihin Sıfır Noktası', 'meshur' => 'Göbeklitepe, Balıklıgöl, Urfa Çiğ Köftesi, Urfa Kebabı, Sıra Geceleri', 'kapak' => 'images/urfa.webp',
            'gezilecekler' => [
                ['baslik' => 'Göbeklitepe Ören Yeri', 'acıklama' => 'İnsanlık tarihinin bilinen en eski inanç ve tapınak merkezi. 12 bin yıllık geçmişiyle tarım öncesi avcı-toplayıcı insanların yaptığı devasa T biçimli taş sütunlar.'],
                ['baslik' => 'Balıklıgöl (Halil-ür Rahman)', 'acıklama' => 'Hz. İbrahim\'in ateşe atıldığında düştüğü yer olduğuna, ateşin suya odunların ise balığa dönüştüğüne inanılan kutsal kutsal havuz havzası.']
            ],
            'yapilacaklar' => ['Tarihi konaklarda akşam sazlı sözlü, acılı orijinal Çiğ Köfteli geleneksel Sıra Gecelerine katılın.', 'Harran ilçesine giderek dünyaca ünlü kubbeli toprak Harran Kümbet Evlerini fotoğraflayın.']
        ],
        1 => [
            'ad' => 'Mardin', 'bolge' => 'Güneydoğu Anadolu Bölgesi', 'slogan' => 'Gündüzü Seyran, Gecesi Gerdanlık Taş Şehir', 'meshur' => 'Tarihi Taş Evler, Deyrulzafaran Manastırı, Telkari Gümüşü, Süryani Kahvesi', 'kapak' => 'images/mardin.jpg',
            'gezilecekler' => [
                ['baslik' => 'Eski Mardin Sokakları ve Kasımiye Medresesi', 'acıklama' => 'Sarı kalker taşından yapılan, hiçbirinin gölgesi diğerinin üstüne düşmeyen tarihi evler, sokak altı geçitleri (Abbaralar) ve Mezopotamya manzaralı eyvanlı medrese.'],
                ['baslik' => 'Deyrulzafaran Manastırı', 'acıklama' => 'Asırlar boyunca Süryani ortodoks patriklerinin ikametgahı olan, antik güneş tapınağı üzerine kurulu aktif tarihi manastır kompleksi.']
            ],
            'yapilacaklar' => ['Eski çarşıdaki gümüş atölyelerinde incecik gümüş tellerle örülen el sanatı Telkari ürünlerini inceleyin.', 'Mezopotamya ovasına yukarıdan bakan teras kafelerde çift kavrulmuş Süryani Kahvesi için.']
        ],
        2 => [
            'ad' => 'Gaziantep', 'bolge' => 'Güneydoğu Anadolu Bölgesi', 'slogan' => 'Gastronomi Başkenti ve Mozaiklerin İhtişamı', 'meshur' => 'Zeugma Müzesi (Çingene Kızı), Antep Baklavası, Almacı Çarşısı, Beyran Çorbası', 'kapak' => 'images/antep.jpg',
            'gezilecekler' => [
                ['baslik' => 'Zeugma Mozaik Müzesi', 'acıklama' => 'Fırat nehri kıyısındaki antik kentten kurtarılan, gizemli bakışlarıyla büyüleyen ünlü "Çingene Kızı" mozaiğinin sergilendiği dünyanın en zengin mozaik müzelerinden biri.'],
                ['baslik' => 'Tarihi Bakırcılar ve Almacı Çarşıları', 'acıklama' => 'Çekiç seslerinin yankılandığı dar sokaklar, kurutulmuş patlıcan-biber dolmalıklarının asılı olduğu otantik baharatçılar çarşısı şeridi.']
            ],
            'yapilacaklar' => ['Sabah gün doğarken sarımsaklı, kuzu etli ve pirinçli enerji deposu Beyran Çorbası için.', 'Çıtır çıtır, bol fıstıklı ve sıcak şerbetli orijinal Antep Baklavası yiyin.']
        ],
        3 => [
            'ad' => 'Adıyaman', 'bolge' => 'Güneydoğu Anadolu Bölgesi', 'slogan' => 'Kommagene Krallığı, Güneşin En Güzel Doğduğu Zirve', 'meshur' => 'Nemrut Dağı Devasa Tanrı Heykelleri, Cendere Köprüsü', 'kapak' => 'images/adiyaman.jpg',
            'gezilecekler' => [
                ['baslik' => 'Nemrut Dağı Ören Yeri', 'acıklama' => '2150 metre yükseklikteki dağın zirvesinde, Kommagene kralı Antiochus\'un mezarı önünde yer alan metrelerce yükseklikteki dev taş kartal, aslan ve tanrı başı heykelleri.'],
                ['baslik' => 'Cendere Köprüsü', 'acıklama' => 'Roma İmparatoru Septimius Severus döneminde tek bir kaya bloku üzerine harç kullanılmadan inşa edilen iki dev sütunlu tarihi köprü.']
            ],
            'yapilacaklar' => ['Nemrut Dağı zirvesine akşamüstü tırmanarak dev heykellerin arkasından batan büyüleyici gün batımını seyredin.', 'Tarihi Perre Antik Kenti kaya mezarlarını gezin.']
        ],
        4 => [
            'ad' => 'Diyarbakır', 'bolge' => 'Güneydoğu Anadolu Bölgesi', 'slogan' => 'Binlerce Yıllık Surların ve Hanların Kadim Şehri', 'meshur' => 'Diyarbakır Surları, Hevsel Bahçeleri, Hasan Paşa Hanı, Diyarbakır Ciğeri', 'kapak' => 'images/diyarbakir.jpg',
            'gezilecekler' => [
                ['baslik' => 'Diyarbakır Surları ve Keçi Burcu', 'acıklama' => 'Çin Seddi\'nden sonra dünyanın en uzun ve en geniş savunma duvarı sistemlerinden biri kabul edilen siyah bazalt taşından yapılmış UNESCO mirası surlar.'],
                ['baslik' => 'Tarihi Ulu Camii', 'acıklama' => 'Anadolu\'nun en eski camilerinden biri olan, beşinci harem-i şerif kabul edilen şık sütunlu Selçuklu mimari yapısı.']
            ],
            'yapilacaklar' => ['Tarihi Hasan Paşa Hanı\'nın avlusundaki kafelerde masayı dolduran zengin şark kahvaltısını yapın.', 'Sur içinde köz ateşinde şişlere dizilmiş taze lokum gibi Diyarbakır Ciğeri yiyin.']
        ],
        5 => [
            'ad' => 'Batman', 'bolge' => 'Güneydoğu Anadolu Bölgesi', 'slogan' => 'Dicle Nehri Kıyısındaki Mağaralar ve Petrol Kent', 'meshur' => 'Hasankeyf Antik Kenti ve Yeni Müze Alanı, Raman Dağı', 'kapak' => 'images/batman.jpg',
            'gezilecekler' => [
                ['baslik' => 'Hasankeyf Yeni Kültür Parkı Ören Yeri', 'acıklama' => 'Ilısu baraj gölü suları altında kalan kadim kentin taşınan tarihi anıtlarının (Zeynel Bey Türbesi, El Rızk Camii) ve kanyon kaya mezarlarının sergilendiği yeni müze yerleşkesi.'],
                ['baslik' => 'Mor Kuryakos Manastırı', 'acıklama' => 'Batman sınırlarında yer alan, Süryani cemaati için büyük tarihi önem taşıyan köklü bir taş manastır yapısı.']
            ],
            'yapilacaklar' => ['Hasankeyf müze binasında eski çağlara ait arkeolojik kazı bulgularını inceleyin.', 'Yöresel et dolgulu içli köfte olan Batman Şam Böreğini tadın.']
        ],
    
    ]
];

// Gelen ID'lerin havuzda var olup olmadığını kontrol eden güvenlik duvarı
if (!array_key_exists($gelen_bolge_id, $tum_sehirler_havuzu)) { $gelen_bolge_id = 1; }
if (!array_key_exists($gelen_sehir_sira, $tum_sehirler_havuzu[$gelen_bolge_id])) { $gelen_sehir_sira = 0; }

$sehir = $tum_sehirler_havuzu[$gelen_bolge_id][$gelen_sehir_sira];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $sehir['ad']; ?> Detaylı Gezi Rehberi</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sehir-body { font-family: 'Poppins', sans-serif; background: #f8fafc; margin: 0; padding: 0; color: #1e293b; }
        .sehir-hero { position: relative; height: 420px; background: url('<?php echo $sehir['kapak']; ?>') center/cover no-repeat; display: flex; align-items: center; justify-content: center; color: white; text-align: center; }
        .sehir-hero::before { content: ''; position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(15, 23, 42, 0.5); }
        .hero-icerik { position: relative; z-index: 5; max-width: 900px; padding: 0 20px; }
        .hero-icerik .ust-etiket { background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(5px); padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; text-transform: uppercase; display: inline-block; margin-bottom: 15px; }
        .hero-icerik h1 { font-size: 52px; font-weight: 800; margin: 0 0 12px 0; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        .hero-icerik p { font-size: 20px; font-style: italic; opacity: 0.95; margin: 0; }
        .ana-konteyner { max-width: 1100px; margin: 40px auto; padding: 0 20px 80px 20px; display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
        .sol-blok h2, .sag-blok h3 { font-size: 24px; font-weight: 700; color: #0f172a; margin: 0 0 25px 0; display: flex; align-items: center; gap: 10px; }
        .sol-blok h2 i { color: #3b82f6; }
        .gezilecek-kart { background: white; border-radius: 14px; padding: 25px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
        .gezilecek-kart h4 { margin: 0 0 8px 0; font-size: 18px; font-weight: 700; color: #1e293b; }
        .gezilecek-kart p { margin: 0; font-size: 14px; color: #475569; line-height: 1.6; }
        .sag-blok { display: flex; flex-direction: column; gap: 30px; }
        .sag-blok h3 i { color: #10b981; }
        .bilgi-kutusu { background: white; border-radius: 14px; padding: 25px; border: 1px solid #e2e8f0; }
        .bilgi-kutusu h4 { margin: 0 0 12px 0; font-size: 13px; color: #64748b; text-transform: uppercase; }
        .bilgi-kutusu p { margin: 0; font-size: 15px; color: #0f172a; font-weight: 500; line-height: 1.6; }
        .liste-kutusu { background: #1e293b; color: white; border-radius: 14px; padding: 30px; }
        .liste-kutusu h3 { color: white; }
        .liste-kutusu h3 i { color: #f59e0b; }
        .aktivite-listesi { margin: 0; padding: 0 0 0 20px; display: flex; flex-direction: column; gap: 15px; }
        .aktivite-listesi li { font-size: 14px; color: #cbd5e1; line-height: 1.6; }
        .geri-don-link { display: inline-flex; align-items: center; gap: 8px; color: #64748b; font-weight: 600; font-size: 14px; text-decoration: none; margin-bottom: 30px; }
        .geri-don-link:hover { color: #0f172a; }
        @media (max-width: 768px) { .ana-konteyner { grid-template-columns: 1fr; } .hero-icerik h1 { font-size: 38px; } }
    </style>
</head>
<body class="sehir-body">

    <?php if(file_exists('header.php')) { include 'header.php'; } ?>

    <div class="sehir-hero">
        <div class="hero-icerik">
            <span class="ust-etiket"><?php echo $sehir['bolge']; ?> Gezi Rehberi</span>
            <h1><?php echo $sehir['ad']; ?></h1>
            <p>"<?php echo $sehir['slogan']; ?>"</p>
        </div>
    </div>

    <div class="ana-konteyner">
        
        <div class="sol-blok">
            <a href="bolge.php?id=<?php echo $gelen_bolge_id; ?>" class="geri-don-link">
                <i class="fas fa-chevron-left"></i> Bölge Şehirlerine Dön
            </a>
            
            <h2><i class="fas fa-map-marked-alt"></i> Mutlaka Gezilmesi Gereken Yerler</h2>
            
            <?php foreach($sehir['gezilecekler'] as $yer): ?>
                <div class="gezilecek-kart">
                    <h4><?php echo $yer['baslik']; ?></h4>
                    <p><?php echo $yer['acıklama']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="sag-blok">
            <div class="bilgi-kutusu">
                <h3><i class="fas fa-star"></i> Neleri Meşhur?</h3>
                <h4>Yöresel Tatlar & Simgeler</h4>
                <p><?php echo $sehir['meshur']; ?></p>
            </div>

            <div class="liste-kutusu">
                <h3><i class="fas fa-clipboard-list"></i> Neler Yapılır?</h3>
                <ul class="aktivite-listesi">
                    <?php foreach($sehir['yapilacaklar'] as $aktivite): ?>
                        <li><?php echo $aktivite; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

    </div>

</body>
</html>