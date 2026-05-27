<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';
mysqli_set_charset($conn, "utf8mb4");

// URL'den gelen şehir parametresini alıyoruz (Örn: sehir_detay.php?sehir=eskişehir)
$sehir = isset($_GET['sehir']) ? trim($_GET['sehir']) : '';

if (empty($sehir)) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($sehir); ?> Rotaları - Gezi Rehberim</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; margin: 0; font-family: 'Segoe UI', sans-serif; }
        .detay-kapsam { max-width: 1140px; margin: 40px auto; padding: 0 20px; }
        .detay-baslik { font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 10px; text-transform: capitalize; }
        .detay-alt { color: #64748b; margin-bottom: 30px; font-size: 16px; }
        .kesif-izgara-alani { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        .tasarim-kesif-kart { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; }
        .tasarim-kesif-kart img { width: 100%; height: 180px; object-fit: cover; }
        .kart-alt-detay { padding: 16px; }
        .kart-konum-baslik { font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 6px 0; }
        .kart-profil-link { font-size: 13px; color: #0284c7; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="detay-kapsam">
        <h1 class="detay-baslik"><i class="fas fa-map-marked-alt" style="color: #38bdf8;"></i> <?php echo htmlspecialchars($sehir); ?> Rotaları</h1>
        <p class="detay-alt">Gezginlerin "<?php echo htmlspecialchars($sehir); ?>" için paylaştığı en popüler gezi rehberleri.</p>

        <div class="kesif-izgara-alani">
            <?php
            // BURASI KRİTİK: Hata veren 20. satırdaki sorguyu tamamen güvenli hale getirdik.
            // Başlığı (baslik) gelen şehir adına eşit olan gönderileri getiriyoruz.
            $sorgu = mysqli_prepare($conn, "SELECT * FROM gonderiler WHERE LOWER(baslik) = LOWER(?) ORDER BY id DESC");
            mysqli_stmt_bind_param($sorgu, "s", $sehir);
            mysqli_stmt_execute($sorgu);
            $sonuc = mysqli_stmt_get_result($sorgu);

            if (mysqli_num_rows($sonuc) > 0) {
                while($row = mysqli_fetch_assoc($sonuc)) {
                    $gorsel = !empty($row['gorsel']) ? $row['gorsel'] : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600';
                    ?>
                    <div class="tasarim-kesif-kart">
                        <img src="<?php echo htmlspecialchars($gorsel); ?>" alt="Rota Görseli">
                        <div class="kart-alt-detay">
                            <div class="kart-konum-baslik">
                                <i class="fas fa-map-marker-alt" style="color:#ef4444;"></i> <?php echo htmlspecialchars($row['baslik']); ?>
                            </div>
                            <p style="font-size: 14px; color: #475569; margin: 8px 0; line-height: 1.4;">
                                <?php echo htmlspecialchars(substr($row['aciklama'] ?? '', 0, 100)); ?>...
                            </p>
                            <a href="profil.php?user=<?php echo urlencode($row['username']); ?>" class="kart-profil-link">
                                @<?php echo htmlspecialchars($row['username']); ?> tarafından paylaşıldı
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div style="grid-column:1/-1; text-align:center; padding: 40px; color:#64748b; background: white; border-radius:12px; border: 1px dashed #cbd5e1;">';
                echo '<i class="far fa-folder-open" style="font-size: 32px; margin-bottom: 10px; color: #94a3b8;"></i><br>';
                echo 'Bu şehir ile ilgili henüz detaylı bir gezi rotası eklenmemiş.';
                echo '</div>';
            }
            ?>
        </div>
    </div>

</body>
</html>