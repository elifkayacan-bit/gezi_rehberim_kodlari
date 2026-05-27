<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username'])) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['username'] = trim($_POST['username']);
}
// 1. Veritabanı bağlantı dosyanı çağırıyoruz
if (file_exists('baglan.php')) {
    include 'baglan.php';
} else {
    die("Hata: baglan.php dosyası bulunamadı! Lütfen dosya adını kontrol edin.");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: giris.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

// --- SİHİRLİ BAĞLANTI BULUCU ---
// baglan.php içindeki doğru veritabanı değişkenini otomatik tespit ediyoruz
$db_baglantisi = null;
if (isset($conn)) { $db_baglantisi = $conn; }
elseif (isset($Sconn)) { $db_baglantisi = $Sconn; }
elseif (isset($db)) { $db_baglantisi = $db; }
elseif (isset($baglan)) { $db_baglantisi = $baglan; }
else {
    die("Hata: Veritabanı bağlantı değişkeni bulunamadı. Lütfen baglan.php dosyanızdaki değişken adını kontrol edin.");
}
// -------------------------------

// Kullanıcı verilerini çekiyoruz
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $db_baglantisi->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 1. PROFİL FOTOĞRAFI GÜNCELLEME
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $upload_dir = 'uploads/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $new_file_name = "avatar_" . $user_id . "_" . time() . "." . $file_extension;
        $target_file = $upload_dir . $new_file_name;
        
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
            $av_sql = "UPDATE users SET avatar = ? WHERE id = ?";
            $av_stmt = $db_baglantisi->prepare($av_sql);
            $av_stmt->bind_param("si", $target_file, $user_id);
            if ($av_stmt->execute()) {
                $user['avatar'] = $target_file;
                header("Location: profil.php");
                exit;
            }
        } else {
            $error_msg = "Fotoğraf klasöre yazılamadı. Yükleme izni hatası olabilir.";
        }
    }
    
   // 2. KULLANICI ADI GÜNCELLEME
    if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
        $new_username = trim($_POST['username']);
        $up_sql = "UPDATE users SET username = ? WHERE id = ?";
        $up_stmt = $db_baglantisi->prepare($up_sql);
        $up_stmt->bind_param("si", $new_username, $user_id);
        if ($up_stmt->execute()) { 
            $user['username'] = $new_username; 
            
            // SİHİRLİ DOKUNUŞ: Eğer session içinde 'username' tutuluyorsa onu da güncelliyoruz
            if (isset($_SESSION['username'])) {
                $_SESSION['username'] = $new_username;
            }
        }
    }

    // 3. EMAIL ADRESİ GÜNCELLEME
    if (isset($_POST['email']) && !empty(trim($_POST['email']))) {
        $new_email = trim($_POST['email']);
        if ($new_email != $user['email']) {
            $email_sql = "UPDATE users SET email = ? WHERE id = ?";
            $email_stmt = $db_baglantisi->prepare($email_sql);
            $email_stmt->bind_param("si", $new_email, $user_id);
            if ($email_stmt->execute()) {
                $user['email'] = $new_email;
            }
        }
    }

    // 4. ŞİFRE DEĞİŞTİRME MEKANİZMASI
    if (!empty($_POST['old_password']) && !empty($_POST['new_password'])) {
        if (password_verify($_POST['old_password'], $user['password']) || $_POST['old_password'] == $user['password']) {
            $hashed_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $ps_sql = "UPDATE users SET password = ? WHERE id = ?";
            $ps_stmt = $db_baglantisi->prepare($ps_sql);
            $ps_stmt->bind_param("si", $hashed_password, $user_id);
            $ps_stmt->execute();
        } else { 
            $error_msg = "Mevcut şifreniz hatalı!"; 
        }
    }
    
    if (empty($error_msg)) {
        header("Location: profil.php");
        exit;
    }
}

$profil_resmi = (!empty($user['avatar']) && file_exists($user['avatar'])) ? $user['avatar'] : 'https://cdnjs.cloudflare.com/ajax/libs/twemoji/14.0.2/72x72/1f464.png';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profili Düzenle</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style type="text/css">
        html, body {
            margin: 0 !important; padding: 0 !important;
            background-color: #f0f4f8 !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            width: 100% !important; min-height: 100vh !important;
        }
        .bagimsiz-navbar {
            background-color: #212529 !important; height: 70px !important; width: 100% !important;
            display: flex !important; align-items: center !important; justify-content: space-between !important;
            padding: 0 40px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important; box-sizing: border-box !important;
        }
        .navbar-sol { display: flex !important; align-items: center !important; gap: 25px !important; }
        .navbar-logo { color: #ffffff !important; font-size: 22px !important; font-weight: 800 !important; text-decoration: none !important; }
        .navbar-link { color: #ced4da !important; text-decoration: none !important; font-weight: 500 !important; font-size: 15px !important; }
        .navbar-sag { display: flex !important; align-items: center !important; gap: 15px !important; }
        .navbar-gp-badge { background-color: #ffc107 !important; color: #212529 !important; padding: 8px 16px !important; border-radius: 20px !important; font-weight: 700 !important; font-size: 14px !important; }
        .navbar-logout-btn { background-color: #dc3545 !important; color: #ffffff !important; text-decoration: none !important; padding: 8px 18px !important; border-radius: 20px !important; font-weight: 600 !important; }
        .sayfa-ortala-wrapper { display: flex !important; align-items: center !important; justify-content: center !important; padding: 40px 20px !important; width: 100% !important; box-sizing: border-box !important; }
        .mobil-dikey-kart { background: #ffffff !important; width: 100% !important; max-width: 420px !important; border-radius: 35px !important; box-shadow: 0 20px 45px rgba(0,0,0,0.06) !important; padding: 45px 30px !important; text-align: center !important; box-sizing: border-box !important; }
        .girdi-satir-alani { margin-bottom: 22px !important; text-align: left !important; width: 100% !important; box-sizing: border-box !important; }
        .girdi-baslik-etiket { display: block !important; font-weight: 700 !important; color: #1e293b !important; margin-bottom: 8px !important; font-size: 13.5px !important; }
        .girdi-kapsama-kutusu { position: relative !important; width: 100% !important; display: flex !important; align-items: center !important; }
        .saf-tasarim-input { width: 100% !important; height: 52px !important; padding: 0 45px 0 18px !important; border: 1.5px solid #e2e8f0 !important; border-radius: 16px !important; font-size: 14.5px !important; color: #334155 !important; outline: none !important; box-sizing: border-box !important; }
        .input-ic-ikon { position: absolute !important; right: 18px !important; color: #94a3b8 !important; }
        .guncelle-buton-mavi { width: 100% !important; height: 54px !important; background-color: #00a2e8 !important; color: #ffffff !important; border: none !important; border-radius: 18px !important; font-size: 16px !important; font-weight: 700 !important; cursor: pointer !important; margin-top: 10px !important; box-shadow: 0 6px 20px rgba(0,162,232,0.18) !important; }
        .iptal-yazisi { color: #64748b !important; text-decoration: none !important; font-weight: 600; display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>

    <div class="bagimsiz-navbar">
        <div class="navbar-sol">
            <a href="index.php" class="navbar-logo">GeziRehberim</a>
            <a href="profil.php" class="navbar-link"><i class="fas fa-arrow-left"></i> Profile Dön</a>
        </div>
    </div>

    <div class="sayfa-ortala-wrapper">
        <div class="mobil-dikey-kart">
            
            <form action="profili_duzenle.php" method="POST" enctype="multipart/form-data">
                
                <div style="margin-bottom: 35px; display: inline-block; position: relative; width: 130px; height: 130px;">
                    <div style="width: 130px; height: 130px; border-radius: 50%; background-color: #e2e8f0; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 4px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        <img src="<?php echo $profil_resmi; ?>" id="preview" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <label for="file-input" style="position: absolute; top: 4px; right: 4px; background-color: #e2e8f0; color: #64748b; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; cursor: pointer; border: 3px solid #ffffff; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">+</label>
                    <input id="file-input" type="file" name="avatar" style="display: none;" onchange="previewImage(this)">
                </div>

                <?php if($error_msg): ?>
                    <div style="background-color: #fef2f2; color: #991b1b; padding: 12px; border-radius: 14px; margin-bottom: 20px; font-size: 13px; font-weight: 600; text-align: center;"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <div class="girdi-satir-alani">
                    <label class="girdi-baslik-etiket">Kullanıcı Adı</label>
                    <div class="girdi-kapsama-kutusu">
                        <input type="text" name="username" class="saf-tasarim-input" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
                        <i class="fas fa-user input-ic-ikon"></i>
                    </div>
                </div>

                <div class="girdi-satir-alani">
                    <label class="girdi-baslik-etiket">Email Adresi</label>
                    <div class="girdi-kapsama-kutusu">
                        <input type="email" name="email" class="saf-tasarim-input" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                        <i class="fas fa-envelope input-ic-ikon"></i>
                    </div>
                </div>

                <div class="girdi-satir-alani">
                    <label class="girdi-baslik-etiket">Şifren</label>
                    <div class="girdi-kapsama-kutusu">
                        <input type="password" name="old_password" class="saf-tasarim-input" placeholder="Enter current password">
                        <i class="fas fa-lock input-ic-ikon"></i>
                    </div>
                </div>

                <div class="girdi-satir-alani">
                    <label class="girdi-baslik-etiket">Yeni Şifren</label>
                    <div class="girdi-kapsama-kutusu">
                        <input type="password" name="new_password" class="saf-tasarim-input" placeholder="Enter new password">
                        <i class="fas fa-key input-ic-ikon"></i>
                    </div>
                </div>

                <button type="submit" class="guncelle-buton-mavi">Profili Güncelle</button>
                <br>
                <a href="profil.php" class="iptal-yazisi">İptal</a>

            </form>
        </div>
    </div>

    <script type="text/javascript">
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</body>
</html>