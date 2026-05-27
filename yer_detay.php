<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

// Adresten gelen id parametresini güvenli bir şekilde alalım
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Veritabanından ilgili yeri çekelim
    $sorgu = mysqli_query($conn, "SELECT * FROM onerilen_yerler WHERE id = $id");
    $yer = mysqli_fetch_assoc($sorgu);
    
    // Eğer böyle bir id yoksa önerilen yerlere geri dönsün
    if (!$yer) {
        header("Location: onerilen_yerler.php");
        exit();
    }
} else {
    header("Location: onerilen_yerler.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($yer['baslik']); ?> - Gezi Rehberim</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .detay-konteyner {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
            font-family: 'Poppins', sans-serif;
        }

        .detay-Geri-Kutusu {
            margin-bottom: 20px;
        }

        .btn-geri {
            text-decoration: none;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }
        .btn-geri:hover { color: #1e293b; }

        .detay-resim-alani {
            width: 100%;
            height: 450px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .detay-resim-alani img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .detay-ust-satir {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .detay-konum {
            font-size: 15px;
            font-weight: 600;
            color: #3498db;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .detay-puan {
            background: #fef3c7;
            color: #d97706;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .detay-konteyner h1 {
            font-size: 32px;
            color: #1e293b;
            margin: 0 0 20px 0;
            font-weight: 700;
        }

        .detay-metni {
            font-size: 16px;
            color: #475569;
            line-height: 1.8;
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="detay-konteyner">
        
        <div class="detay-Geri-Kutusu">
            <a href="onerilen_yerler.php" class="btn-geri">
                <i class="fas fa-arrow-left"></i> Önerilen Yerlere Dön
            </a>
        </div>

        <div class="detay-resim-alani">
            <img src="<?php echo $yer['foto']; ?>" alt="<?php echo htmlspecialchars($yer['baslik']); ?>">
        </div>

        <div class="detay-ust-satir">
            <span class="detay-konum">
                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($yer['sehir']); ?>
            </span>
            <span class="detay-puan">
                <i class="fas fa-star"></i> <?php echo $yer['puan']; ?> / 5.0
            </span>
        </div>

        <h1><?php echo htmlspecialchars($yer['baslik']); ?></h1>

        <div class="detay-metni">
            <p><?php echo nl2br(htmlspecialchars($yer['aciklama'])); ?></p>
        </div>

    </div>

</body>
</html>