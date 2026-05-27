<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php'; 

$arama_yapildi = false;
$seferler_listesi = [];
$secilen_tip = isset($_POST['ulasim_tipi']) ? $_POST['ulasim_tipi'] : 'otobus';

// PHP Tarafında Giriş Kontrol Değişkeni
$kullanici_giris_yapti = isset($_SESSION['username']) ? true : false;
$giris_yapan_ad = $kullanici_giris_yapti ? htmlspecialchars($_SESSION['username']) : 'Misafir Kullanıcı';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nereden = isset($_POST['origin']) ? mb_convert_case(trim($_POST['origin']), MB_CASE_TITLE, "UTF-8") : '';
    $nereye = isset($_POST['destination']) ? mb_convert_case(trim($_POST['destination']), MB_CASE_TITLE, "UTF-8") : '';
    $tarih = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
    $iade_tarih = isset($_POST['return_date']) ? $_POST['return_date'] : date('Y-m-d', strtotime('+3 days'));
    
    if(!empty($nereden)) {
        // Havuz verileri
        $otobus_firmalari = ['Kamil Koç', 'Pamukkale Turizm', 'Metro Turizm', 'Ali Osman Ulusoy', 'Varan Turizm'];
        $ucak_firmalari = ['Türk Hava Yolları', 'Pegasus', 'AnadoluJet', 'SunExpress'];
        $tren_firmalari = ['TCDD Taşımacılık (YHT)', 'TCDD Taşımacılık (Ekspres)'];
        
        // Araç kiralama havuzu
        $arac_firmalari = ['Avis', 'Enterprise', 'Garenta', 'Sixt', 'Budget', 'Hertz'];
        $arac_modeller = [
            ['isim' => 'Fiat Egea (Ekonomik)', 'foto' => 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=400', 'yakit' => 'Dizel', 'vites' => 'Manuel'],
            ['isim' => 'Renault Clio (Ekonomik)', 'foto' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=400', 'yakit' => 'Benzin', 'vites' => 'Otomatik'],
            ['isim' => 'Dacia Duster (SUV)', 'foto' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=400', 'yakit' => 'Dizel', 'vites' => 'Manuel'],
            ['isim' => 'Volkswagen Passat (Konfor)', 'foto' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=400', 'yakit' => 'Hibrit', 'vites' => 'Otomatik']
        ];

        $sefer_sayisi = rand(3, 5);

        for ($i = 0; $i < $sefer_sayisi; $i++) {
            $saat = str_pad(rand(6, 23), 2, "0", STR_PAD_LEFT);
            $dakika = ['00', '15', '30', '45'][rand(0, 3)];
            $kalkis_saati = "$saat:$dakika";

            if($secilen_tip === 'otobus') {
                $seferler_listesi[] = [
                    'firma_adi' => $otobus_firmalari[array_rand($otobus_firmalari)],
                    'firma_logo' => 'fas fa-bus',
                    'detay' => $nereden . ' <i class="fas fa-long-arrow-alt-right" style="color:#3498db; margin:0 5px;"></i> ' . $nereye,
                    'orta_bilgi' => '<i class="far fa-clock"></i> Saat: ' . $kalkis_saati,
                    'fiyat' => rand(500, 950),
                    'buton_metni' => 'Bilet Seç',
                    'alert_metni' => 'Biletiniz seçildi!'
                ];
            } elseif($secilen_tip === 'ucak') {
                $seferler_listesi[] = [
                    'firma_adi' => $ucak_firmalari[array_rand($ucak_firmalari)],
                    'firma_logo' => 'fas fa-plane',
                    'detay' => $nereden . ' <i class="fas fa-long-arrow-alt-right" style="color:#3498db; margin:0 5px;"></i> ' . $nereye,
                    'orta_bilgi' => '<i class="far fa-clock"></i> Saat: ' . $kalkis_saati,
                    'fiyat' => rand(1300, 2100),
                    'buton_metni' => 'Bilet Seç',
                    'alert_metni' => 'Uçak biletiniz seçildi!'
                ];
            } elseif($secilen_tip === 'tren') {
                $seferler_listesi[] = [
                    'firma_adi' => $tren_firmalari[array_rand($tren_firmalari)],
                    'firma_logo' => 'fas fa-train',
                    'detay' => $nereden . ' <i class="fas fa-long-arrow-alt-right" style="color:#3498db; margin:0 5px;"></i> ' . $nereye,
                    'orta_bilgi' => '<i class="far fa-clock"></i> Saat: ' . $kalkis_saati,
                    'fiyat' => rand(250, 480),
                    'buton_metni' => 'Bilet Seç',
                    'alert_metni' => 'Tren biletiniz seçildi!'
                ];
            } elseif($secilen_tip === 'kiralama') {
                $secilen_arac = $arac_modeller[$i % count($arac_modeller)];
                $seferler_listesi[] = [
                    'firma_adi' => $arac_firmalari[array_rand($arac_firmalari)],
                    'firma_logo' => 'fas fa-car',
                    'detay' => '<strong style="color:#2c3e50;" class="arac-model-text">' . $secilen_arac['isim'] . '</strong><br><span style="font-size:12px; color:#64748b;"><i class="fas fa-map-marker-alt"></i> Alış Yeri: ' . $nereden . '</span>',
                    'orta_bilgi' => '<span style="font-size:13px; color:#475569;"><i class="fas fa-gas-pump"></i> Yakıt: <span class="arac-yakit-text">' . $secilen_arac['yakit'] . '</span><br><i class="fas fa-cog"></i> Vites: <span class="arac-vites-text">' . $secilen_arac['vites'] . '</span></span>',
                    'fiyat' => rand(850, 1600),
                    'buton_metni' => 'Aracı Kirala',
                    'gunluk_notu' => ' / Günlük',
                    'iade_tarihi_degeri' => $iade_tarih,
                    'alert_metni' => 'Araç kiralama talebiniz alındı! Rezervasyon onay kodunuz oluşturuluyor.'
                ];
            }
        }
    }
    $arama_yapildi = true;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulaşım ve Bilet Sorgulama - Gezi Rehberim</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .ulasim-konteyner { max-width: 1000px; margin: 50px auto; padding: 0 20px; font-family: 'Poppins', sans-serif; }
        .ulasim-baslik { text-align: center; margin-bottom: 35px; }
        .ulasim-baslik h1 { font-size: 28px; color: #1e293b; font-weight: 700; margin-bottom: 10px; }
        .ulasim-baslik p { color: #64748b; font-size: 15px; }
        .ulasim-sekmeler { display: flex; justify-content: center; gap: 15px; margin-bottom: 25px; flex-wrap: wrap; }
        .sekme-btn { background: #f1f5f9; border: none; padding: 12px 25px; border-radius: 30px; font-size: 14px; font-weight: 600; color: #64748b; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .sekme-btn:hover { background: #e2e8f0; color: #1e293b; }
        .sekme-btn.aktif { background: #3498db; color: white; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3); }
        .bilet-form-kutusu { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        .form-satir { display: grid; grid-template-columns: repeat(3, 1fr) auto; gap: 20px; align-items: flex-end; }
        .grup-input { display: flex; flex-direction: column; gap: 8px; }
        .grup-input label { font-size: 13px; font-weight: 600; color: #475569; }
        .input-alan { position: relative; }
        .input-alan i { position: absolute; left: 15px; top: 24px; transform: translateY(-50%); color: #94a3b8; font-size: 15px; }
        .input-alan input { width: 100%; padding: 14px 15px 14px 42px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; color: #1e293b; outline: none; box-sizing: border-box; }
        .input-alan input:focus { border-color: #3498db; }
        .btn-bilet-ara { background: #2ecc71; color: white; border: none; padding: 14px 30px; border-radius: 12px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; height: 48px; transition: background 0.2s; }
        .btn-bilet-ara:hover { background: #27ae60; }
        .sonuclar-alani { margin-top: 40px; }
        .sonuclar-baslik { font-size: 18px; color: #1e293b; margin-bottom: 20px; font-weight: 600; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
        .bilet-kart { background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; display: grid; grid-template-columns: 2fr 2.5fr 2fr 1.5fr; align-items: center; margin-bottom: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
        .bilet-firma { display: flex; align-items: center; gap: 12px; font-weight: 700; color: #1e293b; }
        .bilet-firma i { font-size: 20px; color: #e67e22; }
        .bilet-guzerhah { font-size: 14px; color: #2c3e50; font-weight: 500; }
        .bilet-fiyat-alan { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 5px; }
        .bilet-ucret { font-size: 18px; font-weight: 700; color: #2ecc71; }
        .btn-satinal { background: #1e293b; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease; }
        .btn-satinal:hover { background: #334155; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="ulasim-konteyner">
        
        <div class="ulasim-baslik">
            <h1>Ulaşım Rehberi ve Sefer Sorgulama</h1>
            <p>Gitmek istediğiniz rotayı seçin; en uygun bilet veya kiralık araç seçeneklerini anında listeleyelim.</p>
        </div>

        <div class="ulasim-sekmeler">
            <button type="button" class="sekme-btn <?php echo $secilen_tip == 'otobus' ? 'aktif' : ''; ?>" onclick="sekmeDegistir('otobus')"><i class="fas fa-bus"></i> Otobüs Bileti</button>
            <button type="button" class="sekme-btn <?php echo $secilen_tip == 'ucak' ? 'aktif' : ''; ?>" onclick="sekmeDegistir('ucak')"><i class="fas fa-plane"></i> Uçak Bileti</button>
            <button type="button" class="sekme-btn <?php echo $secilen_tip == 'tren' ? 'aktif' : ''; ?>" onclick="sekmeDegistir('tren')"><i class="fas fa-train"></i> Tren / YHT</button>
            <button type="button" class="sekme-btn <?php echo $secilen_tip == 'kiralama' ? 'aktif' : ''; ?>" onclick="sekmeDegistir('kiralama')"><i class="fas fa-car"></i> Araç Kiralama</button>
        </div>

        <div class="bilet-form-kutusu">
            <form action="ulasim.php" method="POST" id="ulasimForm">
                <input type="hidden" name="ulasim_tipi" id="ulasim_tipi" value="<?php echo $secilen_tip; ?>">
                
                <div class="form-satir">
                    <div class="grup-input">
                        <label id="labelNereden">Nereden (Alış Yeri)</label>
                        <div class="input-alan">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" name="origin" id="inputNereden" placeholder="Örn: Ankara" value="<?php echo isset($_POST['origin']) ? htmlspecialchars($_POST['origin']) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="grup-input" id="boxNereye">
                        <label>Nereye</label>
                        <div class="input-alan">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" name="destination" id="inputNereye" placeholder="Örn: İzmir" value="<?php echo isset($_POST['destination']) ? htmlspecialchars($_POST['destination']) : ''; ?>">
                        </div>
                    </div>

                    <div class="grup-input">
                        <label id="labelTarih">Gidiş Tarihi</label>
                        <div class="input-alan">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="date" name="date" id="inputTarih" value="<?php echo isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <div class="grup-input" id="boxIadeTarihi" style="display: none;">
                        <label>İade Tarihi</label>
                        <div class="input-alan">
                            <i class="fas fa-calendar-check"></i>
                            <input type="date" name="return_date" id="inputIadeTarih" value="<?php echo isset($_POST['return_date']) ? $_POST['return_date'] : date('Y-m-d', strtotime('+3 days')); ?>">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn-bilet-ara">
                            <i class="fas fa-search"></i> <span id="btnMetni">Sefer Bul</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <?php if ($arama_yapildi): ?>
            <div class="sonuclar-alani">
                <h3 class="sonuclar-baslik">
                    <i class="fas fa-list"></i> Uygun Sonuçlar (<?php echo count($seferler_listesi); ?> Seçenek Bulundu)
                </h3>

                <?php if (count($seferler_listesi) > 0): ?>
                    <?php foreach ($seferler_listesi as $index => $sefer): ?>
                        <?php
                        $indirim_tutari = 0;
                        $kullanici_gp = 0;
                        $orijinal_fiyat = isset($sefer['fiyat']) ? $sefer['fiyat'] : 0;

                        if (isset($_SESSION['username']) && isset($conn)) {
                            $u_name = $_SESSION['username'];
                            $user_sorgu = mysqli_query($conn, "SELECT gezi_puani FROM users WHERE username = '$u_name'");
                            if ($user_row = mysqli_fetch_assoc($user_sorgu)) {
                                $kullanici_gp = $user_row['gezi_puani'];
                                $indirim_tutari = $kullanici_gp; 
                            }
                        }

                        $odenecek_fiyat = $orijinal_fiyat - $indirim_tutari;
                        if($odenecek_fiyat < ($orijinal_fiyat / 2)) { 
                            $odenecek_fiyat = $orijinal_fiyat / 2;
                            $indirim_tutari = $orijinal_fiyat / 2;
                        }
                        ?>
                        <div class="bilet-kart">
                            <div class="bilet-firma">
                                <i class="<?php echo $sefer['firma_logo']; ?>" style="color: <?php echo $secilen_tip == 'kiralama' ? '#334155' : '#3498db'; ?>;"></i>
                                <span class="firma-adi-text"><?php echo htmlspecialchars($sefer['firma_adi']); ?></span>
                            </div>
                            <div class="bilet-guzerhah">
                                <?php echo $sefer['detay']; ?>
                            </div>
                            <div class="bilet-saat">
                                <?php echo $sefer['orta_bilgi']; ?>
                            </div>
                            <div class="bilet-fiyat-alan">
                                <?php if ($indirim_tutari > 0): ?>
                                    <span style="text-decoration: line-through; color: #94a3b8; font-size: 13px;">
                                        <?php echo number_format($orijinal_fiyat, 2, ',', '.'); ?> TL
                                    </span>
                                    <span class="bilet-ucret" style="color: #e11d48;">
                                        <span class="aktif-hesaplanan-ucret"><?php echo number_format($odenecek_fiyat, 2, ',', '.'); ?></span> TL<span style="font-size:12px; font-weight:normal; color:#64748b;"><?php echo isset($sefer['gunluk_notu']) ? $sefer['gunluk_notu'] : ''; ?></span>
                                    </span>
                                    <span style="font-size:11px; background:#2ecc71; color:white; padding:2px 6px; border-radius:10px; font-weight:bold; margin-top:2px; display:inline-block;">
                                        🎉 <?php echo $indirim_tutari; ?> TL GP İndirimi!
                                    </span>
                                <?php else: ?>
                                    <span class="bilet-ucret">
                                        <span class="aktif-hesaplanan-ucret"><?php echo number_format($orijinal_fiyat, 2, ',', '.'); ?></span> TL<span style="font-size:12px; font-weight:normal; color:#64748b;"><?php echo isset($sefer['gunluk_notu']) ? $sefer['gunluk_notu'] : ''; ?></span>
                                    </span>
                                <?php endif; ?>

                                <button id="islem-btn-<?php echo $index; ?>" class="btn-satinal" style="margin-top:5px;" onclick="kurumsalBiletSureciBaslat('<?php echo $secilen_tip === 'kiralama' ? 'Araç Kiralama' : 'Gezgin Bilet Kartı'; ?>', this, <?php echo $index; ?>)">
                                    <?php echo $sefer['buton_metni']; ?>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

    <div id="biletOnayModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); z-index: 99999; justify-content: center; align-items: center;">
        <div style="background: #ffffff; border-radius: 8px; max-width: 480px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border-top: 4px solid #0f172a; padding: 25px;">
            <div style="text-align: left; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 15px;">
                <h3 style="margin: 0; color: #0f172a; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">GÜVENLİ İŞLEM ONAYI</h3>
            </div>
            <div id="onayOzetAlani" style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 12px; font-size: 13px; color: #334155; margin-bottom: 20px; line-height: 1.8;"></div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button onclick="biletIptalEt()" style="background: #ffffff; color: #475569; border: 1px solid #cbd5e1; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 13px;">İptal Et</button>
                <button onclick="biletOnayla()" style="background: #0f172a; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 13px;">Onayla ve Oluştur</button>
            </div>
        </div>
    </div>

    <div id="gercekBiletModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.8); z-index: 100000; justify-content: center; align-items: center; padding: 20px 0;">
        <div style="max-width: 850px; width: 95%; background: #ffffff; border-radius: 12px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); overflow: hidden; border: 1px solid #cbd5e1;" id="biletAnaKonteyner">
            
            <div id="biletUstBar" style="background: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="width: 6px; height: 6px; background-color: #0f172a; border-radius: 50%;" id="biletUstNokta"></span>
                    <span style="font-size: 11px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 1px;" id="biletUstEtiket">Elektronik Seyahat Sureti</span>
                </div>
                <div style="display: flex; gap: 12px;">
                    <button onclick="biletDosyaOlarakIndir()" id="biletIndirBtn" style="background: #0f172a; border: 1px solid #0f172a; color: #ffffff; font-size: 11px; padding: 8px 18px; cursor: pointer; font-weight: 700; text-transform: uppercase; border-radius: 6px; display: flex; align-items: center; gap: 6px; transition: all 0.3s;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Dökümanı İndir
                    </button>
                    <button onclick="biletKapat()" style="background: #f8fafc; border: 1px solid #cbd5e1; color: #64748b; font-size: 11px; padding: 8px 18px; cursor: pointer; font-weight: 600; text-transform: uppercase; border-radius: 6px;">
                        Pencereyi Kapat
                    </button>
                </div>
            </div>

            <div id="biletYazdirilabilirGövde" style="background: #ffffff; min-height: 230px; position: relative; padding: 25px;">
                
                <div id="klasikBiletSablonu" style="display: flex; width: 100%;">
                    <div style="flex: 3; padding-right: 25px; display: flex; flex-direction: column; justify-content: space-between;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <div style="font-size: 16px; font-weight: 800; color: #0f172a; letter-spacing: 0.5px; text-transform: uppercase;" id="biletFirmaAdi">-</div>
                            <div style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 1.5px;" id="biletYanalBaslik">BOARDING PASS</div>
                        </div>
                        
                        <div style="display: flex; align-items: center; margin-bottom: 20px;">
                            <div style="flex: 1;">
                                <span style="font-size: 30px; font-weight: 800; color: #0f172a; display: block; line-height: 1;" id="biletNeredenKod">---</span>
                                <span style="font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase;" id="biletNeredenSehir">-</span>
                            </div>
                            <div style="flex: 1; text-align: center; position: relative; display: flex; align-items: center; justify-content: center;">
                                <div style="position: absolute; width: 100%; height: 1px; border-top: 2px dashed #cbd5e1; z-index: 1;"></div>
                                <span style="font-size: 18px; background: #ffffff; padding: 0 10px; z-index: 2; color: #64748b;" id="biletMerkezIkon">✈️</span>
                            </div>
                            <div style="flex: 1; text-align: right;">
                                <span style="font-size: 30px; font-weight: 800; color: #0f172a; display: block; line-height: 1;" id="biletNereyeKod">---</span>
                                <span style="font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase;" id="biletNereyeSehir">-</span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                            <div>
                                <span style="font-size: 9px; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 2px;">MÜŞTERİ / YOLCU</span>
                                <span style="font-size: 12px; font-weight: 700; color: #1e293b; text-transform: uppercase;"><?php echo $giris_yapan_ad; ?></span>
                            </div>
                            <div>
                                <span style="font-size: 9px; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 2px;">TARİH</span>
                                <span style="font-size: 12px; font-weight: 700; color: #1e293b;" id="biletTarih">-</span>
                            </div>
                            <div>
                                <span style="font-size: 9px; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 2px;">KOLTUK / NO</span>
                                <span style="font-size: 12px; font-weight: 700; color: #1e293b;">12B</span>
                            </div>
                            <div>
                                <span style="font-size: 9px; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 2px;">PNR KODU</span>
                                <span style="font-size: 12px; font-weight: 800; color: #000000;" id="biletPnr">-</span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="flex: 1; background: #fafafa; border-left: 2px dashed #cbd5e1; padding-left: 20px; display: flex; flex-direction: column; justify-content: space-between;" id="biletKocanKapsam">
                        <div>
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 10px;" id="biletKocanFirma">-</div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; align-items: center;">
                                <span style="font-size: 15px; font-weight: 800; color: #1e293b;" id="biletKocanNereden">---</span>
                                <span style="color: #cbd5e1; font-size: 11px;">➔</span>
                                <span style="font-size: 15px; font-weight: 800; color: #1e293b;" id="biletKocanNereye">---</span>
                            </div>
                            <div style="margin-bottom: 4px;">
                                <span style="font-size: 8px; color: #94a3b8; font-weight: bold; display: block;">AD SOYAD:</span>
                                <span style="font-size: 11px; font-weight: 700; color: #334155; text-transform: uppercase;"><?php echo $giris_yapan_ad; ?></span>
                            </div>
                            <div>
                                <span style="font-size: 8px; color: #94a3b8; font-weight: bold; display: block;">TARİH:</span>
                                <span style="font-size: 11px; font-weight: 700; color: #334155;" id="biletKocanTarih">-</span>
                            </div>
                        </div>
                        <div style="text-align: center; margin-top: 10px;">
                            <div style="letter-spacing: 1px; font-size: 11px; font-weight: bold; color: #000; font-family: monospace;">|||||||||||||||||||||||</div>
                            <div style="font-size: 8px; color: #64748b; font-family: monospace; margin-top: 2px;" id="biletKocanPnr">-</div>
                        </div>
                    </div>
                </div>

                <div id="aracKiralamaSablonu" style="display: none; width: 100%; flex-direction: column; font-family:'Poppins', sans-serif;">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 20px;">
                        <div>
                            <h2 style="margin: 0; font-size: 20px; color: #1e293b; font-weight: 800;" id="kiralamaFirmaUnvan">AVIS RENT A CAR</h2>
                            <span style="font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Resmi Araç Tahsis ve Rezervasyon Belgesi</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 11px; color: #94a3b8; font-weight: bold; display: block;">REZERVASYON NO</span>
                            <span style="font-size: 16px; font-weight: 800; color: #475569; letter-spacing: 1px;" id="kiralamaRezNo">AV9841</span>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                        <div style="background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <span style="font-size: 10px; color: #64748b; font-weight: 700; display: block; margin-bottom: 5px; text-transform: uppercase;"><i class="fas fa-user" style="color:#475569;"></i> Kiracı Bilgileri</span>
                            <span style="font-size: 13px; font-weight: 700; color: #1e293b; display: block; text-transform: uppercase;"><?php echo $giris_yapan_ad; ?></span>
                            <span style="font-size: 11px; color: #64748b; display: block; margin-top:2px;">T.C. Vatandaşı / Kayıtlı Sürücü</span>
                        </div>
                        <div style="background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <span style="font-size: 10px; color: #64748b; font-weight: 700; display: block; margin-bottom: 5px; text-transform: uppercase;"><i class="fas fa-car" style="color:#475569;"></i> Tahsis Edilen Araç</span>
                            <span style="font-size: 13px; font-weight: 700; color: #1e293b; display: block;" id="kiralamaAracModel">-</span>
                            <span style="font-size: 11px; color: #64748b; display: block; margin-top:2px;" id="kiralamaAracDetay">-</span>
                        </div>
                        <div style="background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <span style="font-size: 10px; color: #64748b; font-weight: 700; display: block; margin-bottom: 5px; text-transform: uppercase;"><i class="fas fa-calendar-alt" style="color:#475569;"></i> Kiralama Dönemi</span>
                            <span style="font-size: 12px; font-weight: 700; color: #1e293b; display: block;" id="kiralamaAlisTar">-</span>
                            <span style="font-size: 11px; color: #e11d48; font-weight: 600; display: block; margin-top:2px;" id="kiralamaIadeTar">-</span>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; border-top: 1px dashed #cbd5e1; padding-top: 15px;">
                        <div style="font-size: 11px; color: #64748b; line-height: 1.6;">
                            <strong style="color:#475569; display:block; margin-bottom:3px;">Sözleşme Koşulları & Önemli Notlar:</strong>
                            • Araç tesliminde sürücü adına düzenlenmiş kredi kartı ve ehliyet zorunludur.<br>
                            • Muafiyetli Kaza Sigortası (CDW) ve Hırsızlık Güvencesi fiyatlara dahildir.<br>
                            • Araç dolu depo teslim edilip, dolu depo geri alınacaktır.
                        </div>
                        <div style="background: #f1f5f9; padding: 12px; border-radius: 8px; text-align: right; display: flex; flex-direction: column; justify-content: center;">
                            <span style="font-size: 10px; color: #475569; font-weight: 700; display: block;">TOPLAM TAHSİL EDİLEN TUTAR</span>
                            <span style="font-size: 20px; font-weight: 800; color: #16a34a;" id="kiralamaMaliucret">- TL</span>
                            <span style="font-size: 10px; color: #2563eb; font-weight: 600; margin-top: 2px;">✓ Ödeme Onaylandı</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        const kullaniciGirisYapti = <?php echo $kullanici_giris_yapti ? 'true' : 'false'; ?>;
        const girisSayfasiAdresi = "giris.php";
        
        let aktifSecilenButon = null;
        let aktifButonIndex = null;
        let satinAlinanBiletler = {};

        function formGorunumuAyarla(tip) {
            const boxNereye = document.getElementById('boxNereye');
            const boxIadeTarihi = document.getElementById('boxIadeTarihi');
            const labelNereden = document.getElementById('labelNereden');
            const labelTarih = document.getElementById('labelTarih');
            const btnMetni = document.getElementById('btnMetni');
            const inputNereye = document.getElementById('inputNereye');
            const formSatir = document.querySelector('.form-satir');

            if (tip === 'kiralama') {
                if(boxNereye) boxNereye.style.display = 'none';
                if(inputNereye) inputNereye.required = false;
                if(boxIadeTarihi) boxIadeTarihi.style.display = 'flex';
                if(labelNereden) labelNereden.innerText = 'Alış Yeri';
                if(labelTarih) labelTarih.innerText = 'Alış Tarihi';
                if(btnMetni) btnMetni.innerText = 'Araç Bul';
                if(formSatir) formSatir.style.gridTemplateColumns = '2fr 1.5fr 1.5fr auto';
            } else {
                if(boxNereye) boxNereye.style.display = 'flex';
                if(inputNereye) inputNereye.required = true;
                if(boxIadeTarihi) boxIadeTarihi.style.display = 'none';
                if(labelNereden) labelNereden.innerText = 'Nereden';
                if(labelTarih) labelTarih.innerText = 'Gidiş Tarihi';
                if(btnMetni) btnMetni.innerText = 'Sefer Bul';
                if(formSatir) formSatir.style.gridTemplateColumns = 'repeat(3, 1fr) auto';
            }
        }

        function sekmeDegistir(tip) {
            document.getElementById('ulasim_tipi').value = tip;
            const butonlar = document.querySelectorAll('.sekme-btn');
            butonlar.forEach(btn => btn.classList.remove('aktif'));
            event.currentTarget.classList.add('aktif');
            formGorunumuAyarla(tip);
        }

        function kurumsalBiletSureciBaslat(biletTipi, butonElementi, index) {
            if (!kullaniciGirisYapti) {
                window.location.href = girisSayfasiAdresi;
                return;
            }

            if (satinAlinanBiletler[index]) {
                eskiBiletiYukleVeGoster(index);
                return;
            }

            aktifSecilenButon = butonElementi;
            aktifButonIndex = index;
            
            let firmaAdi = "Seyahat Firması";
            let kart = butonElementi.closest('.bilet-kart');
            if (kart) {
                let textEl = kart.querySelector('.firma-adi-text');
                if (textEl) firmaAdi = textEl.innerText.trim();
            }

            let neredenVal = document.getElementById("inputNereden") ? document.getElementById("inputNereden").value : 'Ankara';
            let nereyeVal = document.getElementById("inputNereye") ? document.getElementById("inputNereye").value : 'İzmir';
            if(document.getElementById('ulasim_tipi').value === 'kiralama') { nereyeVal = "Merkez Ofis"; }

            let ozetAlani = document.getElementById("onayOzetAlani");
            ozetAlani.innerHTML = `
                <table style="width:100%; border-collapse:collapse;">
                    <tr><td style="font-weight:700; width:35%;">Firma:</td><td>${firmaAdi}</td></tr>
                    <tr><td style="font-weight:700;">Hizmet Sınıfı:</td><td>${biletTipi}</td></tr>
                    <tr><td style="font-weight:700;">Güzergah/Yer:</td><td>${neredenVal} ➔ ${nereyeVal}</td></tr>
                </table>
            `;
            document.getElementById("biletOnayModal").style.display = "flex";
        }

        function biletIptalEt() {
            document.getElementById("biletOnayModal").style.display = "none";
        }

        function biletOnayla() {
            document.getElementById("biletOnayModal").style.display = "none";
            
            let kalkisYeri = (document.getElementById("inputNereden") && document.getElementById("inputNereden").value.trim() !== "") ? document.getElementById("inputNereden").value.trim().toUpperCase() : "ANKARA";
            let varisYeri = (document.getElementById("inputNereye") && document.getElementById("inputNereye").value.trim() !== "") ? document.getElementById("inputNereye").value.trim().toUpperCase() : "IZMIR";
            let tarihVal = document.getElementById("inputTarih") ? document.getElementById("inputTarih").value : "-";
            let iadeTarihVal = document.getElementById("inputIadeTarih") ? document.getElementById("inputIadeTarih").value : "-";
            let ulasimTipi = document.getElementById('ulasim_tipi').value;

            let trMap = {"İ":"I","Ş":"S","Ç":"C","Ğ":"G","Ü":"U","Ö":"O"};
            function kodUret(sehir) {
                let temiz = sehir.split("").map(c => trMap[c] || c).join("");
                return temiz.substring(0, 3).toUpperCase();
            }
            let kKod = kodUret(kalkisYeri);
            let vKod = kodUret(varisYeri);

            let dFirma = "TRAVEL LINE";
            let dModel = "Kiralık Araç";
            let dYakit = "Dizel / Hibrit";
            let dVites = "Otomatik";
            let dUcret = "0,00";

            if (aktifSecilenButon) {
                let kart = aktifSecilenButon.closest('.bilet-kart');
                if(kart) {
                    if(kart.querySelector('.firma-adi-text')) dFirma = kart.querySelector('.firma-adi-text').innerText.trim();
                    if(kart.querySelector('.arac-model-text')) dModel = kart.querySelector('.arac-model-text').innerText.trim();
                    if(kart.querySelector('.arac-yakit-text')) dYakit = kart.querySelector('.arac-yakit-text').innerText.trim();
                    if(kart.querySelector('.arac-vites-text')) dVites = kart.querySelector('.arac-vites-text').innerText.trim();
                    if(kart.querySelector('.aktif-hesaplanan-ucret')) dUcret = kart.querySelector('.aktif-hesaplanan-ucret').innerText.trim();
                }
            }

            let pnrLetter = dFirma.substring(0, 2).toUpperCase().replace('İ', 'I');
            if(pnrLetter.length < 2) pnrLetter = "TR";
            let randPnr = pnrLetter + Math.floor(1000 + Math.random() * 9000);

            satinAlinanBiletler[aktifButonIndex] = {
                kalkisYeri: kalkisYeri,
                varisYeri: varisYeri,
                kKod: kKod,
                vKod: vKod,
                dFirma: dFirma,
                dModel: dModel,
                dYakit: dYakit,
                dVites: dVites,
                dUcret: dUcret,
                tarihVal: tarihVal,
                iadeTarihVal: iadeTarihVal,
                randPnr: randPnr,
                ulasimTipi: ulasimTipi
            };

            biletElemanlariniDoldur(satinAlinanBiletler[aktifButonIndex]);

            if (aktifSecilenButon) {
                aktifSecilenButon.innerText = ulasimTipi === 'kiralama' ? "Sözleşmeyi Gör" : "Bileti Görüntüle";
                aktifSecilenButon.style.background = "#34495e"; 
                aktifSecilenButon.style.color = "#ffffff";
            }

            biletGoster();
        }

        function eskiBiletiYukleVeGoster(index) {
            let biletVerisi = satinAlinanBiletler[index];
            if (biletVerisi) {
                biletElemanlariniDoldur(biletVerisi);
                biletGoster();
            }
        }

        function biletElemanlariniDoldur(veri) {
            let ustEtiket = document.getElementById("biletUstEtiket");
            let biletUstBar = document.getElementById("biletUstBar");
            let biletUstNokta = document.getElementById("biletUstNokta");
            let biletIndirBtn = document.getElementById("biletIndirBtn");
            let biletAnaKonteyner = document.getElementById("biletAnaKonteyner");

            // Şablon panelleri
            let klasikBiletSablonu = document.getElementById("klasikBiletSablonu");
            let aracKiralamaSablonu = document.getElementById("aracKiralamaSablonu");

            if (veri.ulasimTipi === 'kiralama') {
                // ARAÇ KİRALAMA AKTİF - BİLET DEĞİL GERÇEK REZERVASYON FORMU
                klasikBiletSablonu.style.display = "none";
                aracKiralamaSablonu.style.display = "flex";

                // Veri Eşleme
                document.getElementById("kiralamaFirmaUnvan").innerText = veri.dFirma.toUpperCase() + " RENT A CAR";
                document.getElementById("kiralamaRezNo").innerText = veri.randPnr;
                document.getElementById("kiralamaAracModel").innerText = veri.dModel;
                document.getElementById("kiralamaAracDetay").innerText = "Şanzıman: " + veri.dVites + " / Yakıt Tipi: " + veri.dYakit;
                document.getElementById("kiralamaAlisTar").innerText = "Alış: " + veri.tarihVal + " (" + veri.kalkisYeri + ")";
                document.getElementById("kiralamaIadeTar").innerText = "İade: " + veri.iadeTarihVal + " (" + veri.kalkisYeri + ")";
                document.getElementById("kiralamaMaliucret").innerText = veri.dUcret + " TL";

                // Tema Düzenlemeleri
                ustEtiket.innerText = "Resmi Araç Tahsis Formu";
                biletUstBar.style.background = "#f1f5f9";
                biletUstBar.style.borderBottom = "1px solid #cbd5e1";
                biletUstNokta.style.backgroundColor = "#475569";
                ustEtiket.style.color = "#334155";
                biletIndirBtn.style.background = "#475569";
                biletIndirBtn.style.borderColor = "#475569";
                biletAnaKonteyner.style.borderColor = "#cbd5e1";

            } else {
                // KLASİK BİLET SİSTEMLERİ AKTİF (OTOBÜS, UÇAK, TREN)
                klasikBiletSablonu.style.display = "flex";
                aracKiralamaSablonu.style.display = "none";

                document.getElementById("biletNeredenSehir").innerText = veri.kalkisYeri;
                document.getElementById("biletNeredenKod").innerText = veri.kKod;
                document.getElementById("biletNereyeSehir").innerText = veri.varisYeri;
                document.getElementById("biletNereyeKod").innerText = veri.vKod;
                document.getElementById("biletKocanNereden").innerText = veri.kKod;
                document.getElementById("biletKocanNereye").innerText = veri.vKod;
                
                document.getElementById("biletFirmaAdi").innerText = veri.dFirma;
                document.getElementById("biletKocanFirma").innerText = veri.dFirma.substring(0, 15);
                document.getElementById("biletTarih").innerText = veri.tarihVal;
                document.getElementById("biletKocanTarih").innerText = veri.tarihVal;
                document.getElementById("biletPnr").innerText = veri.randPnr;
                document.getElementById("biletKocanPnr").innerText = "*" + veri.randPnr + "*";

                let merkezIkon = document.getElementById("biletMerkezIkon");
                let yanalBaslik = document.getElementById("biletYanalBaslik");
                let biletKocanKapsam = document.getElementById("biletKocanKapsam");

                if (veri.ulasimTipi === 'otobus') {
                    merkezIkon.innerText = "🚌";
                    yanalBaslik.innerText = "OTOBÜS YOLCU BİLETİ";
                    ustEtiket.innerText = "Elektronik Otobüs Bilet Sureti";
                    biletUstBar.style.background = "#e8f5e9";
                    biletUstBar.style.borderBottom = "1px solid #c8e6c9";
                    biletUstNokta.style.backgroundColor = "#16a34a";
                    ustEtiket.style.color = "#14532d";
                    biletIndirBtn.style.background = "#16a34a";
                    biletIndirBtn.style.borderColor = "#16a34a";
                    biletKocanKapsam.style.background = "#f4fbf7";
                    biletAnaKonteyner.style.borderColor = "#c8e6c9";
                } else if (veri.ulasimTipi === 'tren') {
                    merkezIkon.innerText = "🚊";
                    yanalBaslik.innerText = "DEMİRYOLLARI SEYAHAT BİLETİ";
                    ustEtiket.innerText = "Elektronik Tren Bilet Sureti";
                    biletUstBar.style.background = "#fdf2f2";
                    biletUstBar.style.borderBottom = "1px solid #fde8e8";
                    biletUstNokta.style.backgroundColor = "#991b1b";
                    ustEtiket.style.color = "#7f1d1d";
                    biletIndirBtn.style.background = "#991b1b";
                    biletIndirBtn.style.borderColor = "#991b1b";
                    biletKocanKapsam.style.background = "#fffdfd";
                    biletAnaKonteyner.style.borderColor = "#fde8e8";
                } else {
                    merkezIkon.innerText = "✈️";
                    yanalBaslik.innerText = "BOARDING PASS";
                    ustEtiket.innerText = "Elektronik Seyahat Sureti";
                    biletUstBar.style.background = "#f0f4f8";
                    biletUstBar.style.borderBottom = "1px solid #d9e2ec";
                    biletUstNokta.style.backgroundColor = "#0f172a";
                    ustEtiket.style.color = "#102a43";
                    biletIndirBtn.style.background = "#0f172a";
                    biletIndirBtn.style.borderColor = "#0f172a";
                    biletKocanKapsam.style.background = "#fafbfc";
                    biletAnaKonteyner.style.borderColor = "#cbd5e1";
                }
            }
        }

        function biletDosyaOlarakIndir() {
            let biletGovde = document.getElementById("biletYazdirilabilirGövde");
            let pnrKod = satinAlinanBiletler[aktifButonIndex] ? satinAlinanBiletler[aktifButonIndex].randPnr : "BELGE";
            
            html2canvas(biletGovde, { scale: 2, useCORS: true, backgroundColor: "#ffffff" }).then(canvas => {
                let data = canvas.toDataURL("image/png");
                let link = document.createElement("a");
                link.download = "Kiralama-Belgesi-" + pnrKod + ".png";
                link.href = data;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        }

        function biletGoster() { document.getElementById("gercekBiletModal").style.display = "flex"; }
        function biletKapat() { document.getElementById("gercekBiletModal").style.display = "none"; }

        window.onload = function() {
            formGorunumuAyarla('<?php echo $secilen_tip; ?>');
        };
    </script>
</body>
</html>