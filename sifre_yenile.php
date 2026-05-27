<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

$hata = "";
$basari = "";
$asama = 1; // 1: E-posta Girme, 2: Yeni Şifre Girme
$islem_yapilacak_email = "";

// 1. AŞAMA: E-POSTA KONTROLÜ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_kontrol'])) {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        $sorgu = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        
        if (mysqli_num_rows($sorgu) === 1) {
            // Kullanıcı bulundu, e-posta adresini session'a atıp 2. aşamaya geçiriyoruz
            $_SESSION['sifre_sifirlama_email'] = $email;
            $asama = 2;
        } else {
            $hata = "Bu e-posta adresine ait bir hesap bulunamadı!";
            $asama = 1;
        }
    } else {
        $hata = "Lütfen e-posta adresinizi girin!";
        $asama = 1;
    }
}

// 2. AŞAMA: YENİ ŞİFREYİ KAYDETME
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sifre_guncelle'])) {
    if (isset($_SESSION['sifre_sifirlama_email'])) {
        $islem_yapilacak_email = $_SESSION['sifre_sifirlama_email'];
        $yeni_sifre = $_POST['yeni_sifre'];
        $yeni_sifre_tekrar = $_POST['yeni_sifre_tekrar'];

        if (!empty($yeni_sifre) && !empty($yeni_sifre_tekrar)) {
            if ($yeni_sifre === $yeni_sifre_tekrar) {
                // Şifreyi güvenli hale getirip veritabanında güncelliyoruz
                $yeni_sifre_hash = password_hash($yeni_sifre, PASSWORD_DEFAULT);
                $guncelle = mysqli_query($conn, "UPDATE users SET password = '$yeni_sifre_hash' WHERE email = '$islem_yapilacak_email'");
                
                if ($guncelle) {
                    $basari = "Şifreniz başarıyla güncellendi! Giriş yapabilirsiniz.";
                    unset($_SESSION['sifre_sifirlama_email']); // Temizlik
                    $asama = 3; // Başarılı sonuç aşaması
                } else {
                    $hata = "Şifre güncellenirken bir hata oluştu!";
                    $asama = 2;
                }
            } else {
                $hata = "Girdiğiniz şifreler birbiriyle eşleşmiyor!";
                $asama = 2;
            }
        } else {
            $hata = "Lütfen tüm şifre alanlarını doldurun!";
            $asama = 2;
        }
    } else {
        $hata = "Oturum süresi doldu, lütfen işlemi baştan başlatın.";
        $asama = 1;
    }
}

// Sayfa yenilendiğinde eğer session'da e-posta kalmışsa doğrudan 2. aşamada kalmasını sağlayalım
if ($asama == 1 && isset($_SESSION['sifre_sifirlama_email'])) {
    $asama = 2;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifremi Unuttum - Gezi Rehberim</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8fafc;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .merkez-konteyner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 150px);
            padding: 20px;
        }
        .form-icerik {
            text-align: center;
            width: 100%;
            max-width: 380px;
        }
        .form-icerik h2 {
            font-size: 24px;
            color: #1e293b;
            margin: 0 0 8px 0;
            font-weight: 700;
        }
        .form-icerik p {
            font-size: 14px;
            color: #64748b;
            margin: 0 0 30px 0;
        }
        .input-grubu {
            position: relative;
            margin-bottom: 18px;
        }
        .input-grubu i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
        }
        .input-grubu input {
            width: 100%;
            padding: 15px 15px 15px 48px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            background: #ffffff;
            color: #334155;
            transition: border-color 0.2s;
        }
        .input-grubu input:focus {
            border-color: #38bdf8;
        }
        .btn-mavi-giris {
            width: 100%;
            background: #38bdf8;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.25);
            transition: background 0.2s;
            margin-top: 10px;
        }
        .btn-mavi-giris:hover {
            background: #0ea5e9;
        }
        .hata-kutusu {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fee2e2;
            padding: 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
        }
        .basari-kutusu {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            padding: 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
        }
        .geri-link-alani {
            margin-top: 25px;
        }
        .geri-link {
            color: #64748b;
            font-size: 14px;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .geri-link:hover {
            color: #1e293b;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="merkez-konteyner">
        <div class="form-icerik">
            
            <?php if ($asama == 1): ?>
                <h2>Şifrenizi mi Unuttunuz?</h2>
                <p>Sistemde kayıtlı e-posta adresinizi girerek doğrulama adımını tamamlayın.</p>

                <?php if(!empty($hata)): ?>
                    <div class="hata-kutusu"><?php echo $hata; ?></div>
                <?php endif; ?>

                <form action="sifre_yenile.php" method="POST">
                    <div class="input-grubu">
                        <i class="far fa-envelope"></i>
                        <input type="email" name="email" placeholder="E-posta Adresiniz" required>
                    </div>
                    <button type="submit" name="email_kontrol" class="btn-mavi-giris">E-postayı Doğrula</button>
                </form>

            <?php elseif ($asama == 2): ?>
                <h2>Yeni Şifre Belirleyin</h2>
                <p>Hesabınız için güçlü ve yeni bir şifre oluşturun.</p>

                <?php if(!empty($hata)): ?>
                    <div class="hata-kutusu"><?php echo $hata; ?></div>
                <?php endif; ?>

                <form action="sifre_yenile.php" method="POST">
                    <div class="input-grubu">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="yeni_sifre" placeholder="Yeni Şifreniz" required>
                    </div>
                    <div class="input-grubu">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="yeni_sifre_tekrar" placeholder="Yeni Şifre Tekrar" required>
                    </div>
                    <button type="submit" name="sifre_guncelle" class="btn-mavi-giris">Şifremi Güncelle</button>
                </form>

            <?php elseif ($asama == 3): ?>
                <h2>Harika!</h2>
                <p>İşlem başarıyla sonlandırıldı.</p>
                
                <?php if(!empty($basari)): ?>
                    <div class="basari-kutusu"><?php echo $basari; ?></div>
                <?php endif; ?>

                <a href="giris.php" class="btn-mavi-giris" style="display: block; text-decoration: none; box-sizing: border-box;">Şimdi Giriş Yap</a>
            <?php endif; ?>

            <?php if ($asama != 3): ?>
                <div class="geri-link-alani">
                    <a href="giris.php" class="geri-link"><i class="fas fa-arrow-left"></i> Giriş Ekranına Dön</a>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>