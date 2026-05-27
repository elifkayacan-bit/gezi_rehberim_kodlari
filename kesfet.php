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
$aranan = "";

if (isset($_GET['ara'])) {
    $aranan = mysqli_real_escape_string($conn, trim($_GET['ara']));
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gezginleri Keşfet</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; margin: 0; font-family: 'Segoe UI', system-ui, sans-serif; color: #334155; }
        .kesfet-sayfa-kapsayici { max-width: 800px; margin: 40px auto; padding: 0 20px; }
        
        /* Geri Dönüş Butonu ve Başlık */
        .sayfa-ust-alan { display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px; }
        .sayfa-baslik { font-size: 20px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 10px; margin: 0; }
        .btn-geri { background: white; border: 1px solid #cbd5e1; color: #475569; padding: 10px 18px; border-radius: 12px; font-weight: 600; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-geri:hover { background: #f8fafc; border-color: #94a3b8; color: #1e293b; }

        /* Arama Kutusu Yeniden */
        .arama-kapsam-kutusu { background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 20px; margin-bottom: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01); }
        .arama-form-grup { display: flex; align-items: center; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 30px; padding: 8px 20px; transition: all 0.25s ease; }
        .arama-form-grup:focus-within { border-color: #38bdf8; background: white; box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15); }
        .arama-form-grup input { border: none; background: transparent; outline: none; font-size: 15px; width: 100%; color: #334155; }
        .arama-form-grup button { background: none; border: none; color: #38bdf8; cursor: pointer; font-size: 16px; display: flex; align-items: center; }

        /* Kullanıcı Kartları Listesi */
        .kullanici-liste-kapsayici { display: flex; flex-direction: column; gap: 15px; }
        .kullanici-kart { background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 20px; display: flex; align-items: center; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s; }
        .kullanici-kart:hover { transform: translateY(-2px); box-shadow: 0 6px 12px rgba(0,0,0,0.03); }
        
        .kullanici-sol-bilgi { display: flex; align-items: center; gap: 15px; }
        .kullanici-avatar { width: 55px; height: 55px; border-radius: 50%; background: #e2eafe; border: 2px solid #38bdf8; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #0284c7; }
        .kullanici-isim-grup h4 { margin: 0 0 4px 0; font-size: 16px; font-weight: 700; color: #1e293b; }
        .kullanici-isim-grup span { font-size: 13px; color: #64748b; background: #f1f5f9; padding: 3px 8px; border-radius: 20px; font-weight: 500; }

        .btn-profil-git { background: #38bdf8; color: white; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 600; font-size: 13px; text-decoration: none; transition: background 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .btn-profil-git:hover { background: #0ea5e9; }
        
        .sonuc-yok { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; color: #64748b; font-size: 15px; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="kesfet-sayfa-kapsayici">
        
        <div class="sayfa-ust-alan">
            <h2 class="sayfa-baslik">
                <i class="fas fa-search" style="color: #38bdf8;"></i> 
                <?php echo !empty($aranan) ? '"'.htmlspecialchars($aranan).'" Arama Sonuçları' : 'Gezginleri Keşfet'; ?>
            </h2>
            <a href="profil.php" class="btn-geri"><i class="fas fa-arrow-left"></i> Profilime Dön</a>
        </div>

        <div class="arama-kapsam-kutusu">
            <form action="kesfet.php" method="GET" class="arama-form-grup">
                <input type="text" name="ara" placeholder="Kullanıcı adı veya e-posta arayın..." value="<?php echo htmlspecialchars($aranan); ?>" required>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <div class="kullanici-liste-kapsayici">
            <?php
            if (!empty($aranan)) {
                // Veritabanında kullanıcı adına veya e-postaya göre arama yapıyoruz
                $sorgu_metni = "SELECT * FROM users WHERE username LIKE '%$aranan%' OR email LIKE '%$aranan%' ORDER BY username ASC";
                $sorgu = mysqli_query($conn, $sorgu_metni);

                if (mysqli_num_rows($sorgu) > 0) {
                    while ($satir = mysqli_fetch_assoc($sorgu)) {
                        ?>
                        <div class="kullanici-kart">
                            <div class="kullanici-sol-bilgi">
                                <div class="kullanici-avatar"><i class="fas fa-user"></i></div>
                                <div class="kullanici-isim-grup">
                                    <h4>@<?php echo htmlspecialchars($satir['username']); ?></h4>
                                    <span><i class="fas fa-star" style="color:#f59e0b;"></i> <?php echo isset($satir['gezi_puani']) ? $satir['gezi_puani'] : 0; ?> GP</span>
                                </div>
                            </div>
                            <a href="profil.php?user=<?php echo urlencode($satir['username']); ?>" class="btn-profil-git">
                                <i class="fas fa-external-link-alt"></i> Profili İncele
                            </a>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="sonuc-yok">🔍 Kriterlere uygun hiçbir gezgin bulunamadı. Farklı bir isim yazmayı deneyebilirsiniz.</div>';
                }
            } else {
                echo '<div class="sonuc-yok">💡 Yukarıdaki arama alanını kullanarak diğer gezginleri bulabilir ve profillerini inceleyebilirsiniz.</div>';
            }
            ?>
        </div>

    </div>

</body>
</html>