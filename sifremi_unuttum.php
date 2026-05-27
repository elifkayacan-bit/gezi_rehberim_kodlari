<?php
$mesaj = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['mail_data'])) {
        $mesaj = "Şifre sıfırlama linki başarıyla e-posta adresinize iletildi.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Şifremi Unuttum - Gezi Rehberim</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .kart { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 25px rgba(0,0,0,0.06); width: 100%; max-width: 400px; }
        .form-grup { margin-bottom: 20px; }
        .form-grup label { display: block; margin-bottom: 8px; font-weight: 600; color: #475569; }
        .form-grup input { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; }
        .btn-gonder { background-color: #f39c12; color: white; border: none; padding: 12px; width: 100%; border-radius: 6px; font-weight: 700; cursor: pointer; }
        .mesaj { background-color: #eff6ff; color: #1e40af; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>

    <div class="kart">
        <h2><i class="fas fa-key" style="color: #f39c12;"></i> Şifremi Unuttum</h2>
        <?php if(!empty($mesaj)): ?><div class="mesaj"><?php echo $mesaj; ?></div><?php endif; ?>
        <form action="" method="POST">
            <div class="form-grup">
                <label>E-posta Adresiniz veya Kullanıcı Adınız</label>
                <input type="text" name="mail_data" required placeholder="Sistemde kayıtlı bilgiyi yazın">
            </div>
            <button type="submit" class="btn-gonder">Sıfırlama Kodu Gönder</button>
        </form>
        <a href="giris.php" style="display:block; text-align:center; margin-top:20px; color:#64748b; text-decoration:none;">Giriş Ekranına Dön</a>
    </div>

</body>
</html>