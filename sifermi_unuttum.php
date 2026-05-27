<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

$hata = "";
$mesaj = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        // E-posta adresinin veritabanında olup olmadığını kontrol ediyoruz
        $sorgu = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        
        if (mysqli_num_rows($sorgu) === 1) {
            // Gerçek projelerde buraya e-posta gönderme kodları (PHPMailer vb.) gelir.
            // Şimdilik yerel sunucuda (localhost) çalıştığımız için simüle ediyoruz:
            $mesaj = "Şifre sıfırlama bağlantısı e-posta adresinize gönderildi! (Localhost simülasyonu)";
        } else {
            $hata = "Bu e-posta adresine ait bir hesap bulunamadı!";
        }
    } else {
        $hata = "Lütfen e-posta adresinizi girin!";
    }
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
            <h2>Şifrenizi mi Unuttunuz?</h2>
            <p>Sistemde kayıtlı e-posta adresinizi girerek şifre sıfırlama adımlarını başlatabilirsiniz.</p>

            <?php if(!empty($hata)): ?>
                <div class="hata-kutusu"><?php echo $hata; ?></div>
            <?php endif; ?>

            <?php if(!empty($mesaj)): ?>
                <div class="basari-kutusu"><?php echo $mesaj; ?></div>
            <?php endif; ?>

            <form action="sifre_yenile.php" method="POST">
                <div class="input-grubu">
                    <i class="far fa-envelope"></i>
                    <input type="email" name="email" placeholder="E-posta Adresiniz" required>
                </div>

                <button type="submit" class="btn-mavi-giris">Sıfırlama Bağlantısı Gönder</button>
            </form>

            <div class="geri-link-alani">
                <a href="giris.php" class="geri-link"><i class="fas fa-arrow-left"></i> Giriş Ekranına Dön</a>
            </div>
        </div>
    </div>

</body>
</html>