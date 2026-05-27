<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

// Oturum açılmadıysa paylaşım yapamasın, ana sayfaya yönlensin
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$hata = "";
$basari = "";

if (isset($_POST['gonderi_paylas'])) {
    $sehir_adi = mysqli_real_escape_string($conn, trim($_POST['sehir_adi']));
    $aciklama = mysqli_real_escape_string($conn, trim($_POST['aciklama']));
    $fotograf = mysqli_real_escape_string($conn, trim($_POST['fotograf']));
    
    // İstediğin Özellik: Argo Filtresi Kontrolü
    $yasakli_kelimeler = array("argo1", "kufur1", "argo2", "kufur2"); // Buraya engellemek istediğin kelimeleri yazabilirsin
    $argo_tespit_edildi = false;

    foreach ($yasakli_kelimeler as $kelime) {
        if (stripos($aciklama, $kelime) !== false) {
            $argo_tespit_edildi = true;
            break;
        }
    }

    if ($argo_tespit_edildi) {
        $hata = "Yorumunuzda topluluk kurallarına aykırı (argo/küfür) kelimeler tespit edildiği için paylaşım engellendi!";
    } else {
        // Kullanıcının ID'sini veritabanından çekelim
        $username = $_SESSION['username'];
        $user_bul = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
        $user_veri = mysqli_fetch_assoc($user_bul);
        $user_id = $user_veri['id'];

        // Veritabanına kaydetme
        $ekle = mysqli_query($conn, "INSERT INTO posts (user_id, sehir_adi, aciklama, fotograf) VALUES ($user_id, '$sehir_adi', '$aciklama', '$fotograf')");

        if ($ekle) {
            // İstediğin Özellik: Paylaşım yapınca 10 GP ödül puanı ekleme
            mysqli_query($conn, "UPDATE users SET puan = puan + 10 WHERE id = $user_id");
            $_SESSION['user_puan'] += 10; // Canlı menü puanını güncelle
            
            $basari = "Keşfiniz başarıyla paylaşıldı ve hesabınıza +10 GP eklendi!";
        } else {
            $hata = "Paylaşım yapılırken bir hata oluştu.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Keşif Paylaş - Gezi Rehberim</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="giris-form-kutusu" style="max-width: 550px;">
        <h2 style="text-align: center; margin-top:0; color:#1e272e;"><i class="fas fa-map-marked-alt" style="color:#2ecc71;"></i> Gezi Deneyimini Paylaş</h2>
        
        <?php if(!empty($hata)): ?>
            <div style="color: #e74c3c; margin-bottom: 15px; font-weight: 600; text-align: center;"><?php echo $hata; ?></div>
        <?php endif; ?>

        <?php if(!empty($basari)): ?>
            <div style="color: #2ecc71; margin-bottom: 15px; font-weight: 600; text-align: center;"><?php echo $basari; ?></div>
        <?php endif; ?>

        <form action="paylas.php" method="POST">
            <div class="form-grup">
                <label>Gittiğiniz Şehir / Ülke Adı</label>
                <input type="text" name="sehir_adi" required placeholder="Örn: Eskişehir, Roma, Antalya">
            </div>
            <div class="form-grup">
                <label>Fotoğraf Linki (URL)</label>
                <input type="url" name="fotograf" required placeholder="https://resimlinkiniz.com/foto.jpg">
            </div>
            <div class="form-grup">
                <label>Kültür Notlarınız ve Yorumunuz</label>
                <textarea name="aciklama" rows="5" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:10px; font-family:inherit; resize:vertical;" required placeholder="Neler yaptınız? Oranın kültürü hakkında insanlara ne tavsiye edersiniz?"></textarea>
            </div>
            <button type="submit" name="gonderi_paylas" class="btn-giris" style="background-color: #2ecc71;">Canlı Yayınla (+10 GP)</button>
        </form>
    </div>
</body>
</html>