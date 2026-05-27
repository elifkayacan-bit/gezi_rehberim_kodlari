<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

$hata = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Kullanıcıyı E-posta adresi ile veritabanında arıyoruz
        $sorgu = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        
        if (mysqli_num_rows($sorgu) === 1) {
            $user = mysqli_fetch_assoc($sorgu);
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                
                header("Location: index.php");
                exit();
            } else {
                $hata = "Hatalı şifre girdiniz!";
            }
        } else {
            $hata = "Bu e-posta adresine ait bir hesap bulunamadı!";
        }
    } else {
        $hata = "Lütfen tüm alanları doldurun!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - Gezi Rehberim</title>
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
        .sekme-kapsayici {
            display: flex;
            background: #f1f5f9;
            padding: 6px;
            border-radius: 30px;
            margin-bottom: 35px;
            border: 1px solid #e2e8f0;
        }
        .sekme-link {
            padding: 10px 35px;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.2s ease;
        }
        .sekme-link.aktif {
            background: #ffffff;
            color: #1e293b;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
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
        .input-grubu input::placeholder {
            color: #94a3b8;
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
        
        /* Şifremi Unuttum Alanı İçin Stil */
        .sifremi-unuttum-alani {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 20px;
            padding-right: 4px;
        }
        .sifremi-unuttum-link {
            color: #64748b;
            font-size: 13px;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .sifremi-unuttum-link:hover {
            color: #0ea5e9;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="merkez-konteyner">
        <div class="sekme-kapsayici">
            <a href="giris.php" class="sekme-link aktif">Giriş Yap</a>
            <a href="kayit.php" class="sekme-link">Kayıt Ol</a>
        </div>

        <div class="form-icerik">
            <h2>Tekrar Hoş Geldiniz!</h2>
            <p>Keşfetmeye devam etmek için giriş yapın.</p>

            <?php if(!empty($hata)): ?>
                <div class="hata-kutusu"><?php echo $hata; ?></div>
            <?php endif; ?>

            <form action="giris.php" method="POST">
                <div class="input-grubu">
                    <i class="far fa-envelope"></i>
                    <input type="email" name="email" placeholder="E-posta Adresiniz" required>
                </div>

                <div class="input-grubu">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Şifreniz" required>
                </div>

                <div class="sifremi-unuttum-alani">
                    <a href="sifre_yenile.php" class="sifremi-unuttum-link">Şifremi Unuttum</a>
                </div>

                <button type="submit" class="btn-mavi-giris">Giriş Yap</button>
            </form>
        </div>
    </div>

</body>
</html>