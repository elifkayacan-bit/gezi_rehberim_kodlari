<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<?php
// Eğer kullanıcı giriş yapmışsa veritabanından güncel puanını ve profil resmini çekiyoruz
$guncel_gp = 0;
$profil_resmi = ''; // Resim değişkenini sıfırlıyoruz

if (isset($_SESSION['username']) && isset($conn)) {
    $u_name = $_SESSION['username'];
    
    // VERİTABANI SORGUSU: gezi_puani ile birlikte profil_resmi sütununu da çekiyoruz
    $user_sorgu = mysqli_query($conn, "SELECT gezi_puani, profil_resmi FROM users WHERE username = '$u_name'");
    if ($user_sorgu && $user_row = mysqli_fetch_assoc($user_sorgu)) {
        $guncel_gp = $user_row['gezi_puani'];
        $profil_resmi = $user_row['profil_resmi']; // Veritabanındaki resim yolunu değişkene aktardık
    }
}
?>

<nav class="modern-navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-logo">GeziRehberim</a>
        
        <ul class="navbar-menu">
            <li><a href="index.php"><i class="fas fa-home"></i> Ana Sayfa</a></li>
            <li><a href="onerilen_yerler.php"><i class="fas fa-compass"></i> Önerilen Yerler</a></li>
            <li><a href="ulasim.php"><i class="fas fa-bus"></i> Ulaşım</a></li>
            
            <li>
                <a><i class="fas fa-map-marked-alt"></i> Türkiye <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                <div class="dropdown-menu">
    <a href="bolge.php?id=1">Marmara Bölgesi</a>
    <a href="bolge.php?id=2">İç Anadolu Bölgesi</a>
    <a href="bolge.php?id=3">Ege Bölgesi</a>
    <a href="bolge.php?id=4">Akdeniz Bölgesi</a>
    <a href="bolge.php?id=5">Karadeniz Bölgesi</a>
    <a href="bolge.php?id=6">Doğu Anadolu Bölgesi</a>
    <a href="bolge.php?id=7">Güneydoğu Anadolu Bölgesi</a>
</div>
            </li>
            
            <li>
                <a ><i class="fas fa-globe"></i> Yurt Dışı <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                <div class="dropdown-menu">
    <a href="ulke.php?id=1">İtalya</a>
    <a href="ulke.php?id=2">Fransa</a>
    <a href="ulke.php?id=3">Almanya</a>
    <a href="ulke.php?id=4">İspanya</a>
</div>
            </li>
        </ul>
        
       <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$guncel_gp = 0;
// Varsayılan profil resmi (Eğer kendi resmin yoksa bu görünür)
$nav_avatar = 'https://cdnjs.cloudflare.com/ajax/libs/twemoji/14.0.2/72x72/1f464.png'; 

if (isset($_SESSION['username']) && isset($conn)) {
    $u_name = $_SESSION['username'];
    
    // Sadece puanı çekiyoruz (Böylece bilinmeyen sütun hatası vermez)
    $user_sorgu = mysqli_query($conn, "SELECT gezi_puani FROM users WHERE username = '$u_name'");
    if ($user_sorgu && $nav_user_row = mysqli_fetch_assoc($user_sorgu)) {
        $guncel_gp = $nav_user_row['gezi_puani'];
    }

    // GEÇİCİ / GARANTİ ÇÖZÜM: Profil resmini dosya kontrolüyle buluyoruz.
    // Eğer yüklenen resimler "uploads/KULLANICI_ADI.jpg" veya .png formatındaysa:
    $olasi_jpg = 'uploads/' . $u_name . '.jpg';
    $olasi_png = 'uploads/' . $u_name . '.png';

    if (file_exists($olasi_jpg)) {
        $nav_avatar = $olasi_jpg;
    } elseif (file_exists($olasi_png)) {
        $nav_avatar = $olasi_png;
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.gp-buton {
    background: #f39c12;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
}
.gp-buton:hover {
    background: #e67e22;
}
</style>

<?php if (isset($_SESSION['username'])): ?>
    <button class="gp-buton" onclick="gpBilgiKutusu(true, <?php echo $guncel_gp; ?>)">
        <i class="fas fa-star"></i> <?php echo $guncel_gp; ?> GP
    </button>
<?php else: ?>
    <button class="gp-buton" onclick="gpBilgiKutusu(false, 0)">
        <i class="fas fa-star"></i> 0 GP
    </button>
<?php endif; ?>

<script>
function gpBilgiKutusu(isLoggedIn, puan) {
    if (isLoggedIn) {
        Swal.fire({
            title: '✨ Gezi Puanı (GP) Bakiyeniz',
            html: `Şu anda <strong>${puan} GP</strong> puanınız var.<br><br>
                   <div style="text-align:left; font-size:14px; background:#f8fafc; padding:15px; border-radius:10px;">
                     🚀 <strong>Nasıl Harcanır?</strong><br>
                     Ulaşım modülünden Otobüs, Uçak biletleri alırken veya Araç Kiralarken puanlarınızı <strong>TL İndirimi</strong> olarak kullanabilirsiniz!<br><br>
                     💎 <strong>Nasıl Kazanılır?</strong><br>
                     • Keşif Fotoğrafı Paylaşmak: <strong>+20 GP</strong><br>
                     • Gönderileri Beğenmek: <strong>+5 GP</strong>
                   </div>`,
            icon: 'success',
            confirmButtonText: 'Harika!',
            confirmButtonColor: '#f39c12'
        });
    } else {
        Swal.fire({
            title: '⭐ Gezi Puanı (GP) Nedir?',
            html: `<div style="text-align:left; font-size:14px; color:#475569; line-height:1.6;">
                     Gezi Puanı, Gezi Rehberim platformunda etkileşime geçtikçe kazandığınız sanal ödül puanıdır.<br><br>
                     🔥 <strong>Ayrıcalıklar:</strong><br>
                     • Kazandığınız puanları <strong>Uçak, Otobüs ve Araç Kiralama</strong> işlemlerinde indirim (TL karşılığı) olarak kullanabilirsiniz.<br>
                     • İlk oturum açtığınızda anında <strong>50 GP Başlangıç Hediyesi</strong> kazanırsınız!<br><br>
                     ⚠️ Puan kazanmaya başlamak ve indirimleri görmek için oturum açmanız gerekmektedir.
                   </div>`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: '<i class="fas fa-sign-in-alt"></i> Hemen Giriş Yap',
            cancelButtonText: 'Kapat'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'giris.php';
            }
        });
    }
}
</script>
          <div class="header-sag-alan" style="display: flex; align-items: center; gap: 15px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    

    <?php if (isset($_SESSION['username'])): ?>
    <a href="profil.php" class="kullanici-etiket" style="text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
    <?php if(!empty($profil_resmi)): ?>
        <img src="yuklemeler/<?php echo $profil_resmi; ?>" style="width: 22px; height: 22px; border-radius: 50%; object-fit: cover; border: 1px solid #38bdf8;">
    <?php else: ?>
        <i class="fas fa-user-circle" style="color: #38bdf8; font-size: 16px;"></i> 
    <?php endif; ?>
    <strong style="color: #ffffff; font-weight: 500;"><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
</a>
    
    <a href="cikis.php" style="background: #e11d48; color: white; padding: 8px 16px; border-radius: 25px; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;">
        <i class="fas fa-sign-out-alt"></i> Çıkış Yap
    </a>
<?php else: ?>
    <a href="giris.php" style="background: #38bdf8; color: white; padding: 9px 22px; border-radius: 25px; text-decoration: none; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(56, 189, 248, 0.2); display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;">
        <i class="fas fa-sign-in-alt"></i> Giriş Yap
    </a>
<?php endif; ?>

</div>
</nav>