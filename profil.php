<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

// Oturum açılmamışsa giriş sayfasına yönlendir
if (!isset($_SESSION['username'])) {
    header("Location: giris.php");
    exit();
}

$u_name = $_SESSION['username'];
$mesaj = "";
$mesaj_tip = "";

// Klasör Kontrolü ve Yoksa Otomatik Oluşturma
if (!is_dir('yuklemeler')) {
    @mkdir('yuklemeler', 0777, true);
}

// Header'daki undefined array key "user_puan" hatasını engellemek için güvenli atama yapıyoruz
if (!isset($_SESSION['user_puan'])) {
    $_SESSION['user_puan'] = 0; 
}

// --- TAKİP ET / TAKİBİ BIRAK İŞLEMİ ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['takip_aksiyon'])) {
    $hedef_kullanici = mysqli_real_escape_string($conn, $_POST['hedef_user']);
    if ($hedef_kullanici !== $u_name) {
        $kontrol = mysqli_query($conn, "SELECT id FROM takip_sistemi WHERE takip_eden = '$u_name' AND takip_edilen = '$hedef_kullanici'");
        if (mysqli_num_rows($kontrol) > 0) {
            mysqli_query($conn, "DELETE FROM takip_sistemi WHERE takip_eden = '$u_name' AND takip_edilen = '$hedef_kullanici'");
        } else {
            mysqli_query($conn, "INSERT INTO takip_sistemi (takip_eden, takip_edilen) VALUES ('$u_name', '$hedef_kullanici')");
        }
        header("Location: profil.php?user=" . urlencode($hedef_kullanici));
        exit();
    }
}

// --- Profil Sahibi Kontrolü ---
$profil_sahibi = $u_name;
$baskasinin_profili_mi = false; // Başkasının profili olup olmadığını anlamak için değişken

if (isset($_GET['user']) && !empty($_GET['user'])) {
    $profil_sahibi = mysqli_real_escape_string($conn, $_GET['user']);
    if ($profil_sahibi !== $u_name) {
        $baskasinin_profili_mi = true; // Eğer linkteki kullanıcı oturum açan kişi değilse true yap
    }
}

// Profil sahibi bilgilerini çek
$user_sorgu = mysqli_query($conn, "SELECT * FROM users WHERE username = '$profil_sahibi'");
if (mysqli_num_rows($user_sorgu) == 0) {
    echo "Kullanıcı bulunamadı.";
    exit();
}
$user_data = mysqli_fetch_assoc($user_sorgu);

// Güncel puanı session'a senkronize et (Header hatasını kökten çözmek için)
if (!$baskasinin_profili_mi) {
    $_SESSION['user_puan'] = isset($user_data['gezi_puani']) ? $user_data['gezi_puani'] : 0;
}

// Takipçi ve Takip Edilen Sayıları
$takipci_sorgu = mysqli_query($conn, "SELECT COUNT(*) as toplam FROM takip_sistemi WHERE takip_edilen = '$profil_sahibi'");
$takipci_sayisi = mysqli_fetch_assoc($takipci_sorgu)['toplam'];

$takip_edilen_sorgu = mysqli_query($conn, "SELECT COUNT(*) as toplam FROM takip_sistemi WHERE takip_eden = '$profil_sahibi'");
$takip_edilen_sayisi = mysqli_fetch_assoc($takip_edilen_sorgu)['toplam'];

$biz_takip_ediyor_muyuz = false;
if ($baskasinin_profili_mi) {
    $takip_kontrol = mysqli_query($conn, "SELECT id FROM takip_sistemi WHERE takip_eden = '$u_name' AND takip_edilen = '$profil_sahibi'");
    if (mysqli_num_rows($takip_kontrol) > 0) {
        $biz_takip_ediyor_muyuz = true;
    }
}

// --- KEŞİF GÖNDERİSİ SİLME SİSTEMİ ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gonderi_sil'])) {
    $gonderi_id = intval($_POST['gonderi_id']);
    $kontrol_sorgu = mysqli_query($conn, "SELECT gorsel FROM gonderiler WHERE id = $gonderi_id AND username = '$u_name'");
    if (mysqli_num_rows($kontrol_sorgu) > 0) {
        $gonderi_veri = mysqli_fetch_assoc($kontrol_sorgu);
        $silinecek_gorsel = $gonderi_veri['gorsel'];
        if (!empty($silinecek_gorsel) && strpos($silinecek_gorsel, 'yuklemeler/') !== false && file_exists($silinecek_gorsel)) {
            @unlink($silinecek_gorsel);
        }
        mysqli_query($conn, "DELETE FROM gonderiler WHERE id = $gonderi_id");
        $mesaj = " Keşif gönderisi başarıyla silindi.";
        $mesaj_tip = "basari";
    }
}

// --- DOSYA YÜKLEMELİ KEŞİF PAYLAŞMA SİSTEMİ ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gonderi_paylas'])) {
    $baslik = mysqli_real_escape_string($conn, trim($_POST['post_title']));
    $aciklama = mysqli_real_escape_string($conn, trim($_POST['post_content']));
    $kaydedilecek_gorsel = "";

    if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] === 0) {
        $dosya_adi = $_FILES['post_image']['name'];
        $uzanti = strtolower(pathinfo($dosya_adi, PATHINFO_EXTENSION));
        if (in_array($uzanti, array("jpg", "jpeg", "png", "webp"))) {
            $yeni_gonderi_adi = "kesif_" . uniqid() . "." . $uzanti;
            $hedef_yol = "yuklemeler/" . $yeni_gonderi_adi;
            if (move_uploaded_file($_FILES['post_image']['tmp_name'], $hedef_yol)) {
                $kaydedilecek_gorsel = $hedef_yol;
            }
        }
    }
    if (!empty($baslik) && !empty($aciklama)) {
        if (empty($kaydedilecek_gorsel)) $kaydedilecek_gorsel = "https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600";
        mysqli_query($conn, "INSERT INTO gonderiler (username, baslik, aciklama, gorsel) VALUES ('$u_name', '$baslik', '$aciklama', '$kaydedilecek_gorsel')");
        mysqli_query($conn, "UPDATE users SET gezi_puani = gezi_puani + 20 WHERE username = '$u_name'");
        
        $_SESSION['user_puan'] += 20;
        header("Location: profil.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@<?php echo htmlspecialchars($profil_sahibi); ?> - Profil</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; margin: 0; font-family: 'Segoe UI', system-ui, sans-serif; color: #334155; }
        .profil-sayfa-kapsayici { max-width: 1140px; margin: 40px auto; padding: 0 20px; }
        
        /* Modern Üst Arama Paneli */
        .profil-ust-arama-alani { background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 18px 25px; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; gap: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
        .arama-sol-metin { font-size: 15px; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 10px; }
        .arama-form-grup { display: flex; align-items: center; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 30px; padding: 6px 18px; width: 340px; transition: all 0.25s ease; }
        .arama-form-grup:focus-within { border-color: #38bdf8; background: white; box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15); }
        .arama-form-grup input { border: none; background: transparent; outline: none; font-size: 14px; width: 100%; color: #334155; }
        .arama-form-grup button { background: none; border: none; color: #38bdf8; cursor: pointer; font-size: 15px; display: flex; align-items: center; justify-content: center; }

        /* Eğer arama barı yoksa grid sisteminin düzgün durması için marjin sıfırlama */
        .profil-container { display: grid; grid-template-columns: 280px 1fr; gap: 30px; align-items: start; <?php if($baskasinin_profili_mi) { echo 'margin-top: 25px;'; } ?> }
        
        /* Klasik Sol Kart Tasarımı */
        .sol-kart { background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 30px 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01); }
        .avatar-box { width: 90px; height: 90px; border-radius: 50%; background: #e2eafe; border: 3px solid #38bdf8; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto; font-size: 38px; color: #0284c7; }
        .sol-kart h3 { margin: 0 0 5px 0; font-size: 20px; font-weight: 700; color: #1e293b; }
        .sol-kart .email { margin: 0 0 20px 0; font-size: 13px; color: #64748b; }
        
        /* Klasik Sarı Rozet */
        .puan-rozet { background: #fff3e0; border: 1px solid #ffe0b2; color: #e65100; font-weight: 700; padding: 10px; border-radius: 12px; font-size: 14px; margin-bottom: 12px; display: flex; align-items: center; justify-content: center; gap: 6px; }
        
        /* Sol Blok Butonları */
        .btn-mavi { width: 100%; background: #38bdf8; color: white; border: none; padding: 11px; border-radius: 12px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; margin-bottom: 10px; display: inline-flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none; }
        .btn-mavi:hover { background: #0ea5e9; }
        .btn-gri { width: 100%; background: #f1f5f9; color: #475569; border: none; padding: 11px; border-radius: 12px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 6px; }
        .btn-gri:hover { background: #e2e8f0; }

        /* Sayaç Bölümleri */
        .takip-detay-row { display: flex; justify-content: space-between; border-top: 1px solid #f1f5f9; margin-top: 15px; padding-top: 15px; }
        .takip-detay-sutun { flex: 1; text-align: center; }
        .takip-detay-sutun div:first-child { font-weight: 700; font-size: 16px; color: #1e293b; }
        .takip-detay-sutun div:last-child { font-size: 12px; color: #64748b; }

        /* Sağ Form ve Giriş Alanları */
        .sag-alan { display: flex; flex-direction: column; gap: 30px; }
        .form-kutusu { background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01); }
        .form-kutusu h4 { margin: 0; font-size: 16px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px; }
        
        .eski-input { width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; margin-bottom: 15px; box-sizing: border-box; background: #fdfdfd; outline: none; transition: all 0.2s; }
        .eski-input:focus { border-color: #38bdf8; background: #fff; box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1); }
        
        /* Gelişmiş Yükleme Alanı */
        .ozel-dosya-yukleyici { position: relative; margin-bottom: 15px; margin-top: 20px; }
        .ozel-dosya-yukleyici input[type="file"] { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
        .yukleme-tasarim-alani { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; border: 2px dashed #cbd5e1; border-radius: 12px; background: #f8fafc; transition: all 0.2s ease-in-out; text-align: center; cursor: pointer; }
        .yukleme-tasarim-alani i { font-size: 24px; color: #38bdf8; margin-bottom: 8px; }
        .yukleme-tasarim-alani span { font-size: 13px; color: #475569; font-weight: 500; }
        .yukleme-tasarim-alani p { margin: 4px 0 0 0; font-size: 11px; color: #94a3b8; }
        .ozel-dosya-yukleyici input[type="file"]:hover + .yukleme-tasarim-alani { border-color: #38bdf8; background: #f0f9ff; }

        .btn-kesfi-yayinla { background: #38bdf8; color: white; border: none; padding: 12px 28px; border-radius: 12px; font-weight: 600; font-size: 14px; cursor: pointer; float: right; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .btn-kesfi-yayinla:hover { background: #0ea5e9; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2); }

        /* Paylaşılan Keşifler Kartları */
        .liste-baslik { font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 15px 0; display: flex; align-items: center; gap: 8px; }
        .eski-kesif-kart { background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 20px; display: flex; gap: 20px; align-items: center; position: relative; box-shadow: 0 2px 4px rgba(0,0,0,0.01); }
        .eski-kesif-img { width: 120px; height: 90px; border-radius: 10px; object-fit: cover; background: #f1f5f9; }
        
        .bildirim { padding: 12px 20px; border-radius: 10px; font-size: 14px; margin-bottom: 20px; }
        .bildirim.basari { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="profil-sayfa-kapsayici">

        <?php if (!$baskasinin_profili_mi): ?>
            <div class="profil-ust-arama-alani">
                <div class="arama-sol-metin">
                    <i class="fas fa-compass" style="color: #38bdf8; font-size: 18px;"></i>
                    <span>Yeni gezginler keşfedin ve topluluğa katılın</span>
                </div>
                <form action="kesfet.php" method="GET" class="arama-form-grup">
                    <input type="text" name="ara" placeholder="Gezgin adı arayın..." required>
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        <?php endif; ?>

        <div class="profil-container">
            
            <div class="sol-kart">
              <div class="avatar-box" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto; background: #e2e8f0;">
    <?php 
    // Veritabanında fotoğraf sütununun adı 'avatar' ise ve dosya klasörde mevcutsa onu bas, yoksa varsayılan ikon çıksın
    if (!empty($user_data['avatar']) && file_exists($user_data['avatar'])): 
    ?>
        <img src="<?php echo htmlspecialchars($user_data['avatar']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
    <?php else: ?>
        <i class="fas fa-user" style="font-size: 2.5rem; color: #64748b;"></i>
    <?php endif; ?>
</div>
                <h3>@<?php echo htmlspecialchars($user_data['username']); ?></h3>
                <div class="email"><?php echo htmlspecialchars($user_data['email']); ?></div>
                

                <?php if (!$baskasinin_profili_mi): ?>
                    <div style="padding: 0 10px; margin-top: 15px;">
    <a href="profili_duzenle.php" style="display: block; width: 100%; background: #00a2e8; color: white; text-align: center; padding: 12px 0; border-radius: 8px; font-weight: bold; text-decoration: none; font-size: 0.95rem; transition: background 0.2s; box-shadow: 0 2px 6px rgba(0,162,232,0.2);">
         Profili Düzenle
    </a>
</div>
    
                <?php else: ?>
                    <form action="profil.php" method="POST">
                        <input type="hidden" name="hedef_user" value="<?php echo $profil_sahibi; ?>">
                        <button type="submit" name="takip_aksiyon" class="btn-mavi" style="background: <?php echo $biz_takip_ediyor_muyuz ? '#64748b' : '#38bdf8'; ?>;">
                            <?php echo $biz_takip_ediyor_muyuz ? '<i class="fas fa-user-minus"></i> Takipten Çık' : '<i class="fas fa-user-plus"></i> Takip Et'; ?>
                        </button>
                    </form>
                <?php endif; ?>

                <div class="takip-detay-row">
                    <div class="takip-detay-sutun">
                        <div><?php echo $takipci_sayisi; ?></div>
                        <div>Takipçi</div>
                    </div>
                    <div class="takip-detay-sutun">
                        <div><?php echo $takip_edilen_sayisi; ?></div>
                        <div>Takip</div>
                    </div>
                </div>
            </div>

            <div class="sag-alan">
                <?php if(!empty($mesaj)): ?><div class="bildirim <?php echo $mesaj_tip; ?>"><?php echo $mesaj; ?></div><?php endif; ?>

                <div class="form-kutusu">
                    <?php if (!$baskasinin_profili_mi): ?>
                        <h4 style="margin-bottom: 20px;"><i class="far fa-edit" style="color: #38bdf8;"></i> Yeni Bir Keşif Paylaş (+20 GP)</h4>
                        <form action="profil.php" method="POST" enctype="multipart/form-data">
                            <input type="text" name="post_title" class="eski-input" placeholder="Nereyi Keşfettiniz? (Örn: Eskişehir Odunpazarı Evleri)" required>
                            
                            <div class="ozel-dosya-yukleyici">
                                <input type="file" name="post_image" id="post_image" accept="image/*" onchange="dosyaAdiGoster()">
                                <div class="yukleme-tasarim-alani" id="yukleme_alani">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span id="yukleme_metni">Mekana Ait Bir Fotoğraf Seçin</span>
                                    <p>PNG, JPG, JPEG veya WEBP (Opsiyonel)</p>
                                </div>
                            </div>

                            <textarea name="post_content" class="eski-input" style="height: 110px; resize: none;" placeholder="Deneyimlerinizi, ne yenir, ne yapılır buraya yazın..." required></textarea>
                            
                            <div style="overflow: hidden; width: 100%;">
                                <button type="submit" name="gonderi_paylas" class="btn-kesfi-yayinla"><i class="fas fa-paper-plane"></i> Keşfi Yayınla</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
    <a href="kesfet.php" style="color: #64748b; font-size: 13px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; transition: color 0.2s;" onmouseover="this.style.color='#1e293b'" onmouseout="this.style.color='#64748b'">
        <i class="fas fa-arrow-left"></i> Profilime Dön
    </a>
</div>
                    <?php endif; ?>
                </div>

                <div>
                    <div class="liste-baslik"><i class="fas fa-history" style="color: #38bdf8;"></i> Paylaşılan Keşifler</div>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <?php
                        $gonderi_sorgu = mysqli_query($conn, "SELECT * FROM gonderiler WHERE username = '$profil_sahibi' ORDER BY id DESC");
                        if (mysqli_num_rows($gonderi_sorgu) > 0) {
                            while($gonderi = mysqli_fetch_assoc($gonderi_sorgu)) {
                                ?>
                                <div class="eski-kesif-kart">
                                    <img src="<?php echo htmlspecialchars($gonderi['gorsel']); ?>" class="eski-kesif-img" alt="Keşif">
                                    <div style="flex: 1;">
                                        <h5 style="margin: 0 0 5px 0; font-size: 15px; color: #1e293b; font-weight: 700;"><?php echo htmlspecialchars($gonderi['baslik']); ?></h5>
                                        <p style="margin: 0; font-size: 13px; color: #475569; line-height: 1.5;"><?php echo nl2br(htmlspecialchars($gonderi['aciklama'])); ?></p>
                                    </div>
                                   <?php if (!$baskasinin_profili_mi): ?>
    <form id="silme-formu-<?php echo $gonderi['id']; ?>" action="profil.php" method="POST" style="position: absolute; top: 15px; right: 15px;">
        <input type="hidden" name="gonderi_id" value="<?php echo $gonderi['id']; ?>">
        <button type="button" class="modern-silme-butonu" data-id="<?php echo $gonderi['id']; ?>" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 14px;">
            <i class="fas fa-trash-alt"></i> Sil
        </button>
    </form>
<?php endif; ?>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 30px; text-align: center; color: #64748b; font-size: 14px;">Henüz hiç keşif paylaşılmamış.</div>';
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function dosyaAdiGoster() {
        var input = document.getElementById('post_image');
        var metin = document.getElementById('yukleme_metni');
        var alan = document.getElementById('yukleme_alani');
        
        if (input.files && input.files.length > 0) {
            metin.innerText = "📁 Seçilen Dosya: " + input.files[0].name;
            alan.style.borderColor = "#38bdf8";
            alan.style.background = "#f0f9ff";
        }
    }
    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    // Sayfadaki tüm modern silme butonlarını yakala
    document.querySelectorAll('.modern-silme-butonu').forEach(function(button) {
        button.addEventListener('click', function() {
            var gonderiId = this.getAttribute('data-id');
            var ilgiliForm = document.getElementById('silme-formu-' + gonderiId);

            // Şık onay kutumuz açılıyor
            Swal.fire({
                title: 'Keşfi Silmek İstiyor Musunuz?',
                text: "Bu işlem geri alınamaz ve paylaştığınız keşif tamamen silinir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', /* Canlı Kırmızı */
                cancelButtonColor: '#64748b',  /* Modern Gri */
                confirmButtonText: 'Evet, Sil',
                cancelButtonText: 'Vazgeç',
                background: '#ffffff',
                customClass: {
                    popup: 'sweet-modern-popup'
                }
            }).then((result) => {
                // Kullanıcı onaylarsa formu gerçek anlamda gönderiyoruz
                if (result.isConfirmed) {
                    // Formun submit olduğunu PHP'ye anlatmak için gizli bir girdi ekliyoruz
                    var hiddenSubmit = document.createElement('input');
                    hiddenSubmit.type = 'hidden';
                    hiddenSubmit.name = 'gonderi_sil';
                    ilgiliForm.appendChild(hiddenSubmit);
                    
                    ilgiliForm.submit(); 
                }
            });
        });
    });
});
</script>

<style>
/* Kutuyu web sitene yakışacak şekilde yumuşatmak için CSS */
.sweet-modern-popup {
    border-radius: 24px !important;
    font-family: 'Segoe UI', system-ui, sans-serif !important;
}
</style>
</body>
</html>