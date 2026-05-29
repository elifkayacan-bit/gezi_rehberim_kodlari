
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

header('Content-Type: application/json; charset=utf-8');

// JavaScript'ten POST ile gelen gonderi_id'yi kontrol ediyoruz
if (isset($_POST['gonderi_id'])) {
    
    if (!isset($_SESSION['username'])) {
        echo json_encode(['status' => 'error', 'message' => 'Lütfen önce giriş yapın.']);
        exit();
    }

    $u_name = mysqli_real_escape_string($conn, $_SESSION['username']);
    $gonderi_id = intval($_POST['gonderi_id']); // POST'tan gelen id'yi aldık

    // Kullanıcının daha önce beğenip beğenmediğini kontrol et
    $kontrol = mysqli_query($conn, "SELECT id FROM begeniler WHERE gonderi_id = $gonderi_id AND username = '$u_name'");

    if (mysqli_num_rows($kontrol) > 0) {
        // Zaten beğenmişse beğeniyi geri çek
        $islem = mysqli_query($conn, "DELETE FROM begeniler WHERE gonderi_id = $gonderi_id AND username = '$u_name'");
        $durum = 'silindi';
    } else {
        // Beğenmemişse yeni beğeni ekle
        $islem = mysqli_query($conn, "INSERT INTO begeniler (gonderi_id, username) VALUES ($gonderi_id, '$u_name')");
        $durum = 'eklendi';
    }

    // Güncel toplam beğeni sayısını anlık hesapla
    $sayi_sorgu = mysqli_query($conn, "SELECT COUNT(*) as toplam FROM begeniler WHERE gonderi_id = $gonderi_id");
    $guncel_sayi = mysqli_fetch_assoc($sayi_sorgu)['toplam'];

    if ($islem) {
        echo json_encode([
            'status' => 'success',
            'action' => $durum,
            'likes' => (int)$guncel_sayi
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Veritabanı hatası oluştu.']);
    }
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'gonderi_id parametresi eksik.']);
    exit();
}
?>