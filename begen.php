<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

// Tarayıcıya düz sayfa değil, arka plan verisi (JSON) döneceğimizi söylüyoruz
header('Content-Type: application/json');

if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Lütfen önce giriş yapın.']);
    exit();
}

$u_name = $_SESSION['username'];
$gonderi_id = intval($_GET['id']);

// Kullanıcının daha önce beğenip beğenmediğini kontrol et
$kontrol = mysqli_query($conn, "SELECT id FROM begeniler WHERE gonderi_id = $gonderi_id AND username = '$u_name'");

if (mysqli_num_rows($kontrol) > 0) {
    // Zaten beğenmişse beğeniyi geri çek (Unlike)
    $islem = mysqli_query($conn, "DELETE FROM begeniler WHERE gonderi_id = $gonderi_id AND username = '$u_name'");
    $durum = 'silindi';
} else {
    // Beğenmemişse yeni beğeni ekle (Like)
    $islem = mysqli_query($conn, "INSERT INTO begeniler (gonderi_id, username) VALUES ($gonderi_id, '$u_name')");
    $durum = 'eklendi';
}

// Güncel toplam beğeni sayısını anlık hesapla
$sayi_sorgu = mysqli_query($conn, "SELECT COUNT(*) as toplam FROM begeniler WHERE gonderi_id = $gonderi_id");
$guncel_sayi = mysqli_fetch_assoc($sayi_sorgu)['toplam'];

if ($islem) {
    // Sayfayı yenilemek yerine javascript'e bilgi gönderiyoruz
    echo json_encode([
        'status' => 'success',
        'action' => $durum,
        'likes' => $guncel_sayi
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Veritabanı hatası oluştu.']);
}
exit();
?>