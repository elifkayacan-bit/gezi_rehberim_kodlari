<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';
$oturum_acan = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Kullanıcının önceden beğendiği gönderileri çekelim (Kalbin dolu gelmesi için)
$begenilenler = [];
if (!empty($oturum_acan)) {
    $begeni_kontrol = mysqli_query($conn, "SELECT gonderi_id FROM begeniler WHERE username = '$oturum_acan'");
    if ($begeni_kontrol) {
        while ($b_row = mysqli_fetch_assoc($begeni_kontrol)) {
            $begenilenler[] = $b_row['gonderi_id'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gezi Rehberim - Keşfet</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; margin: 0; font-family: 'Segoe UI', sans-serif; color: #334155; }
        
        /* --- KAPSAYICI HERO ALANI --- */
        .hero-kapsayici {
            position: relative;
            width: 100%;
            height: 480px; 
            background-image: linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)), url('https://images.unsplash.com/photo-1507608869274-d3177c8bb4c7?w=1600');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
        }

        .hero-header-alani {
            width: 100%;
            z-index: 999;
        }

        .hero-header-alani header, .hero-header-alani .navbar {
            background: transparent !important;
            box-shadow: none !important;
        }

        /* --- MERKEZDEKİ ARAMA PANELİ --- */
        .hero-orta-icerik {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 0 20px;
            margin-bottom: 40px;
        }

        .hero-orta-icerik h1 { 
            font-size: 36px; 
            margin: 0 0 10px 0; 
            font-weight: 800; 
            text-shadow: 0 2px 10px rgba(0,0,0,0.6); 
        }

        .hero-orta-icerik p { 
            font-size: 16px; 
            margin: 0 0 25px 0; 
            font-weight: 500;
            text-shadow: 0 2px 6px rgba(0,0,0,0.6); 
        }

        .arama-form-kapsam {
            position: relative;
            width: 100%;
            max-width: 580px;
        }

        .arama-kutusu { 
            background: white; 
            padding: 6px 8px 6px 20px; 
            border-radius: 50px; 
            display: flex; 
            align-items: center; 
            box-shadow: 0 12px 30px rgba(0,0,0,0.25); 
            box-sizing: border-box; 
        }

        .arama-kutusu input { 
            border: none; 
            outline: none; 
            padding: 12px 10px; 
            flex: 1; 
            font-size: 16px; 
            border-radius: 50px; 
            color: #334155; 
            background: transparent; 
        }

        .arama-kutusu button { 
            background: #38bdf8; 
            border: none; 
            color: white; 
            padding: 12px 28px; 
            border-radius: 50px; 
            font-weight: 600; 
            font-size: 15px; 
            cursor: pointer; 
            transition: background 0.2s; 
        }

        .arama-kutusu button:hover { 
            background: #0ea5e9; 
        }

        /* --- CANLI ŞEHİR SONUÇ KUTUSU --- */
        .canli-sehir-listesi {
            position: absolute;
            width: 100%;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 999999 !important; 
            margin-top: 8px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            max-height: 260px;
            overflow-y: auto;
            text-align: left;
        }

        /* Yazıların kaybolmasını engelleyen esnek liste tasarımı */
        .sehir-satir {
            padding: 14px 22px;
            color: #334155;
            cursor: pointer;
            border-bottom: 1px solid #f1f5f9;
            font-size: 15px;
            display: flex !important;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }
        
        .sehir-satir:last-child { border-bottom: none; }
        .sehir-satir:hover { background-color: #f8fafc; color: #0284c7; }
        .sehir-satir i { color: #38bdf8; font-size: 14px; }

        /* Alt Alan Rotalar */
        .kesif-ana-kapsam { max-width: 1140px; margin: 40px auto; padding: 0 20px; }
        .bolum-basligi { font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; }
        .kesif-izgara-alani { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        .tasarim-kesif-kart { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s; }
        .tasarim-kesif-kart:hover { transform: translateY(-4px); }
        .tasarim-kesif-kart img { width: 100%; height: 170px; object-fit: cover; }
        .kart-alt-detay { padding: 16px; flex-grow: 1; }
        .kart-konum-baslik { font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 6px 0; }
        .kart-profil-link { font-size: 13px; color: #0284c7; text-decoration: none; font-weight: 500; }
        
        /* --- DÜZGÜN, SIFIRDAN YAPILMIŞ KALP BUTONU ALANI --- */
        .kalp-alani {
            padding: 12px 16px;
            background: #ffffff;
            display: flex;
            align-items: center;
            border-top: 1px solid #f1f5f9;
        }
        .kalp-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8; /* Varsayılan gri tonlu sınır rengi */
            font-size: 15px;
            font-weight: 600;
            padding: 0;
            outline: none;
            transition: transform 0.15s ease, color 0.15s ease;
        }
        .kalp-btn:active {
            transform: scale(0.85);
        }
        .kalp-btn i {
            font-size: 18px;
        }
        /* Beğenildiğinde aktifleşen kıpkırmızı dinamik sınıf */
        .kalp-btn.aktif {
            color: #ef4444 !important; /* Muhteşem Instagram kırmızısı */
        }
        .kalp-sayi {
            color: #475569;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="hero-kapsayici">
        <div class="hero-header-alani">
            <?php include 'header.php'; ?>
        </div>

        <div class="hero-orta-icerik">
            <h1>Nereyi Keşfetmek İstersiniz?</h1>
            <p>Gitmek istediğiniz şehri yazın, rehberleri anında listeleyin.</p>
            
            <div class="arama-form-kapsam">
                <form id="aramaFormu" class="arama-kutusu" autocomplete="off" onsubmit="event.preventDefault();">
                    <i class="fas fa-search" style="color: #94a3b8; font-size: 16px;"></i>
                    <input type="text" id="arama-input" placeholder="Şehir adı yazın (Örn: Eskişehir, İstanbul)..." autocomplete="off" required>
                    <button type="button" id="aramaButon">Keşfet</button>
                </form>
                
                <div id="canliSonucKutusu" class="canli-sehir-listesi"></div>
            </div>
        </div>
    </div>

    <main class="kesif-ana-kapsam">
        <div class="bolum-basligi">
            <i class="fas fa-map-pin" style="color: #e11d48;"></i> Öne Çıkan Gezi Rotaları
        </div>
        <div class="kesif-izgara-alani">
            <?php
            $ana_sayfa_sorgu = mysqli_query($conn, "SELECT * FROM gonderiler ORDER BY id DESC LIMIT 4");
            if ($ana_sayfa_sorgu && mysqli_num_rows($ana_sayfa_sorgu) > 0) {
                while($row = mysqli_fetch_assoc($ana_sayfa_sorgu)) {
                    $gorsel = !empty($row['gorsel']) ? $row['gorsel'] : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600';
                    $gonderi_id = $row['id'];
                    $current_likes = isset($row['begeni_sayisi']) ? $row['begeni_sayisi'] : 0;
                    
                    // Önceden beğenilmişse 'aktif' sınıfı ve dolu kalp (fas), beğenilmemişse boş kalp (far) gelir
                    $is_liked = in_array($gonderi_id, $begenilenler);
                    $btn_class = $is_liked ? 'kalp-btn aktif' : 'kalp-btn';
                    $icon_class = $is_liked ? 'fas fa-heart' : 'far fa-heart';
                    ?>
                    <div class="tasarim-kesif-kart">
                        <div class="kart-alt-detay">
                            <img src="<?php echo htmlspecialchars($gorsel); ?>" alt="Rota" style="border-radius:8px; margin-bottom:12px;">
                            <div class="kart-konum-baslik">
                                <i class="fas fa-map-marker-alt" style="color:#ef4444;"></i> <?php echo htmlspecialchars($row['baslik']); ?>
                            </div>
                            <a href="profil.php?user=<?php echo urlencode($row['username']); ?>" class="kart-profil-link">
                                @<?php echo htmlspecialchars($row['username']); ?>
                            </a>
                        </div>
                        
                        <div class="kalp-alani">
                            <button class="<?php echo $btn_class; ?>" data-id="<?php echo $gonderi_id; ?>" onclick="kalpTetikle(this)">
                                <i class="<?php echo $icon_class; ?>"></i>
                                <span class="kalp-sayi"><?php echo $current_likes; ?></span>
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div style="grid-column:1/-1; text-align:center; color:#64748b;">Henüz rota eklenmemiş.</div>';
            }
            ?>
        </div>
    </main>

<script>
// SAYFAYI YENİLEMEDEN ANLIK ARTTIRAN VE AZALTAN POPÜLER KALP MOTORU (AJAX)
function kalpTetikle(btn) {
    const oturumAcan = "<?php echo $oturum_acan; ?>";
    if (oturumAcan === "") {
        alert("Lütfen önce giriş yapın!");
        return;
    }

    const gonderiId = btn.getAttribute('data-id');
    const ikon = btn.querySelector('i');
    const sayiElementi = btn.querySelector('.kalp-sayi');
    let mevcutSayi = parseInt(sayiElementi.innerText) || 0;

    if (!btn.classList.contains('aktif')) {
        // İlk defa beğeniliyor: Kırmızı yap, kalbi doldur, sayıyı anında artır
        btn.classList.add('aktif');
        ikon.className = 'fas fa-heart';
        sayiElementi.innerText = mevcutSayi + 1;
    } else {
        // Kalpten çıkılıyor: Kırmızılığı kaldır, kalbin içini boşalt, sayıyı anında düşür
        btn.classList.remove('aktif');
        ikon.className = 'far fa-heart';
        sayiElementi.innerText = mevcutSayi - 1;
    }

    // Veritabanını arkada sessizce güncelle (Sayfa Yenilenmez)
    fetch('begeni_yap.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'gonderi_id=' + gonderiId
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            sayiElementi.innerText = data.new_likes;
            if (data.action === 'liked') {
                btn.classList.add('aktif');
                ikon.className = 'fas fa-heart';
            } else {
                btn.classList.remove('aktif');
                ikon.className = 'far fa-heart';
            }
        } else {
            alert(data.message || "Bir hata oluştu.");
            window.location.reload();
        }
    })
    .catch(err => console.error("Hata:", err));
}

// CANLI ARAMA MOTORU
document.addEventListener("DOMContentLoaded", function() {
    const aramaInput = document.getElementById('arama-input');
    const sonucKutusu = document.getElementById('canliSonucKutusu');
    const aramaFormu = document.getElementById('aramaFormu');

    if (!aramaInput || !sonucKutusu) return;

    aramaInput.addEventListener('input', function() {
        let kelime = this.value.trim();
        if (kelime.length === 0) {
            sonucKutusu.innerHTML = '';
            return;
        }
        
        fetch('arama_yap.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'kelime=' + encodeURIComponent(kelime)
        })
        .then(response => response.text())
        .then(htmlVerisi => {
            sonucKutusu.innerHTML = htmlVerisi;
        });
    });

    sonucKutusu.addEventListener('click', function(e) {
        const satir = e.target.closest('.sehir-satir');
        if (satir) {
            const bolgeId = satir.getAttribute('data-bolge');
            const sehirId = satir.getAttribute('data-sehir');
            const sehirAdi = satir.getAttribute('data-isim');
            
            if (bolgeId !== null && sehirId !== null) {
                aramaInput.value = sehirAdi;
                sonucKutusu.innerHTML = '';
                window.location.href = 'sehir.php?bolge=' + bolgeId + '&sehir=' + sehirId;
            }
        }
    });

    if (aramaFormu) {
        aramaFormu.addEventListener('submit', function(e) {
            e.preventDefault();
            const ilkSatir = sonucKutusu.querySelector('.sehir-satir');
            if (ilkSatir) {
                const bId = ilkSatir.getAttribute('data-bolge');
                const sId = ilkSatir.getAttribute('data-sehir');
                if (bId !== null && sId !== null) {
                    window.location.href = 'sehir.php?bolge=' + bId + '&sehir=' + sId;
                }
            }
        });

        const aramaButon = document.getElementById('aramaButon');
        if (aramaButon) {
            aramaButon.addEventListener('click', function() {
                aramaFormu.dispatchEvent(new Event('submit'));
            });
        }
    }

    document.addEventListener('click', function(e) {
        if (e.target !== sonucKutusu && e.target !== aramaInput) {
            sonucKutusu.innerHTML = '';
        }
    });
});
</script>
</body>
</html>