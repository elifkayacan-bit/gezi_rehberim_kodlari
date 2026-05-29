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
        // Sorguyu senin begeniler tablosuna göre güncelledik
        $ana_sayfa_sorgu = mysqli_query($conn, "SELECT g.*, 
            (SELECT COUNT(*) FROM begeniler WHERE begeniler.gonderi_id = g.id) as toplam_begeni 
            FROM gonderiler g ORDER BY g.id DESC LIMIT 4");

        if ($ana_sayfa_sorgu && mysqli_num_rows($ana_sayfa_sorgu) > 0) {
            while($row = mysqli_fetch_assoc($ana_sayfa_sorgu)) {
                $gorsel = !empty($row['gorsel']) ? $row['gorsel'] : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600';
                $gonderi_id = $row['id'];
                $current_likes = isset($row['toplam_begeni']) ? $row['toplam_begeni'] : 0;
                $aciklama = isset($row['aciklama']) ? $row['aciklama'] : ''; 

                $is_liked = false;
                $icon_class = 'far fa-heart'; 
                $btn_style = '';              

                // Eğer giriş yapılmışsa kullanıcının adına göre kalbin rengini belirle
                if (isset($_SESSION['username'])) {
                    $current_user = mysqli_real_escape_string($conn, $_SESSION['username']);
                    $check_like = mysqli_query($conn, "SELECT * FROM begeniler WHERE username = '$current_user' AND gonderi_id = $gonderi_id");
                    if ($check_like && mysqli_num_rows($check_like) > 0) {
                        $is_liked = true;
                        $icon_class = 'fas fa-heart'; 
                        $btn_style = 'color: #ef4444;'; 
                    }
                }
                ?>
                
                <div class="tasarim-kesif-kart">
                    <div class="kart-alt-detay">
                        <img src="<?php echo htmlspecialchars($gorsel); ?>" alt="Rota" style="border-radius:8px; margin-bottom:12px; width:100%; height:auto;">
                        <div class="kart-konum-baslik">
                            <i class="fas fa-map-marker-alt" style="color:#ef4444;"></i> <?php echo htmlspecialchars($row['baslik']); ?>
                        </div>
                        <?php if(!empty($aciklama)): ?>
                            <div class="kart-aciklama" style="font-size: 13px; color: #4b5563; margin: 6px 0 10px 0; line-height: 1.4;">
                                <?php echo htmlspecialchars($aciklama); ?>
                            </div>
                        <?php endif; ?>
                        <a href="profil.php?user=<?php echo urlencode($row['username']); ?>" class="kart-profil-link">
                            @<?php echo htmlspecialchars($row['username']); ?>
                        </a>
                    </div>
                    
                    <div class="kalp-alani">
                        <button class="kalp-btn" data-id="<?php echo $gonderi_id; ?>" onclick="kalpTetikle(this)" style="background: none; border: none; cursor: pointer; padding: 5px 0; display: flex; align-items: center;">
                            <i class="<?php echo $icon_class; ?>" style="<?php echo $btn_style; ?> font-size: 20px;"></i>
                            <span class="kalp-sayi" id="like-count-<?php echo $gonderi_id; ?>" style="margin-left: 5px;">
                                <?php echo (int)$current_likes; ?>
                            </span>
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

function kalpTetikle(button) {
    const oturumAcikMi = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;
    
    if (!oturumAcikMi) {
        window.location.href = 'giris.php';
        return; 
    }

    const gonderiId = button.getAttribute('data-id');
    const sayacElement = document.getElementById('like-count-' + gonderiId);
    const ikon = button.querySelector('i');
    
    const eskiSayi = parseInt(sayacElement.innerText) || 0;
    const zatenBegenilmis = ikon.classList.contains('fas');

    if (zatenBegenilmis) {
        ikon.className = 'far fa-heart'; 
        ikon.style.color = ''; 
        sayacElement.innerText = Math.max(0, eskiSayi - 1);
    } else {
        ikon.className = 'fas fa-heart'; 
        ikon.style.color = '#ef4444'; 
        sayacElement.innerText = eskiSayi + 1;
    }

    const params = new URLSearchParams();
    params.append('gonderi_id', gonderiId);

    // İSTEK DOĞRUDAN begen.php DOSYANIZA GİDİYOR
    fetch('begen.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            sayacElement.innerText = data.likes;
            if (data.action === 'eklendi') {
                ikon.className = 'fas fa-heart';
                ikon.style.color = '#ef4444';
            } else {
                ikon.className = 'far fa-heart';
                ikon.style.color = '';
            }
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error("Hata:", err);
    });
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
<footer style="background: #1e272e; color: #d2dae2; text-align: center; padding: 25px; font-family: 'Poppins', sans-serif; margin-top: 60px; border-top: 4px solid #3498db;">
    <p style="margin: 0; font-size: 14px; letter-spacing: 0.5px; font-weight: 500;">
        &copy; 2026 GeziRehberim. Bu sitenin tüm hakları saklıdır.
    </p>
</footer>

<div id="modernLoginModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.75); z-index: 99999; justify-content: center; align-items: center; font-family: 'Poppins', sans-serif; backdrop-filter: blur(4px);">
    <div style="background: #ffffff; padding: 40px 30px; border-radius: 20px; width: 90%; max-width: 420px; text-align: center; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); animation: modernPopup 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
        <div style="width: 80px; height: 80px; background: #fff5f5; color: #ff4757; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; font-size: 36px; border: 2px solid #ffe3e3;">
            <i class="fas fa-user-lock"></i>
        </div>
        <h3 style="margin-bottom: 10px; color: #1e272e; font-size: 24px; font-weight: 700;">Oturum Açmalısınız</h3>
        <p style="color: #57606f; font-size: 15px; margin-bottom: 30px; line-height: 1.6;">Rotalarla etkileşime geçmek ve gezginlerin paylaşımlarını keşfetmek için lütfen önce giriş yapın.</p>
        
        <div style="display: flex; gap: 12px; justify-content: center;">
            <a href="giris.php" style="background: #3498db; color: #fff; padding: 14px 30px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 15px; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3); transition: all 0.2s;">Giriş Yap</a>
            <button onclick="document.getElementById('modernLoginModal').style.display='none'" style="background: #f1f2f6; color: #57606f; padding: 14px 30px; border: none; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.2s;">Kapat</button>
        </div>
    </div>
</div>

<style>
@keyframes modernPopup {
    from { transform: scale(0.85); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
</style>

<?php
// Eğer kodlarının yukarısında bir yerde alert bastırıyorsan, bu küçük script onu yakalar ve bizim modern modala çevirir:
echo "<script>
    // Tarayıcının orijinal alert fonksiyonunu kendi kodumuzla değiştiriyoruz
    window.alert = function(mesaj) {
        if(mesaj.includes('giriş') || mesaj.includes('Giriş')) {
            var modal = document.getElementById('modernLoginModal');
            if(modal) {
                modal.style.setProperty('display', 'flex', 'important');
            }
        } else {
            console.log('Standart Mesaj: ' + mesaj);
        }
    };
</script>";
?>
</body>
</html>