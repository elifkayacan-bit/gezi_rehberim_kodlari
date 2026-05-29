<?php
// Hataların ekrana basılıp JSON yapısını bozmasını engelliyoruz
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'baglan.php';

// Veritabanı bağlantı kontrolü
if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'Veritabanı bağlantısı başarısız.']);
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'like' && isset($_POST['gonderi_id'])) {
    
    // 1. Oturum Kontrolü
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        echo json_encode(['success' => false, 'error' => 'Beğenmek için lütfen önce giriş yapın!']);
        exit();
    }

    $username = $_SESSION['username'];
    $post_id = intval($_POST['gonderi_id']);

    // 2. Kullanıcı ID'sini Bulma
    $username_safe = mysqli_real_escape_string($conn, $username);
    $u_sorgu = mysqli_query($conn, "SELECT id FROM users WHERE username='$username_safe'");
    
    if (!$u_sorgu || mysqli_num_rows($u_sorgu) == 0) {
        echo json_encode(['success' => false, 'error' => 'Kullanıcı oturumu veritabanında bulunamadı.']);
        exit();
    }
    
    $u_veri = mysqli_fetch_assoc($u_sorgu);
    $user_id = intval($u_veri['id']);

    // 3. Beğeni Durumu Kontrolü (likes tablosu kontrolü)
    $kontrol = mysqli_query($conn, "SELECT * FROM likes WHERE user_id=$user_id AND post_id=$post_id");

    $status = '';
    if (mysqli_num_rows($kontrol) == 0) {
        // Daha önce beğenilmemiş -> BEĞENİ EKLE
        $islem = mysqli_query($conn, "INSERT INTO likes (user_id, post_id) VALUES ($user_id, $post_id)");
        
        // Kullanıcıya puan ekle (Eğer users tablosunda gezi_puani yoksa hata vermemesi için kontrol kapatılabilir)
        mysqli_query($conn, "UPDATE users SET gezi_puani = gezi_puani + 5 WHERE id = $user_id");
        $status = 'liked';
    } else {
        // Daha önce beğenilmiş -> BEĞENİYİ SİL (Kaldır)
        $islem = mysqli_query($conn, "DELETE FROM likes WHERE user_id=$user_id AND post_id=$post_id");
        
        mysqli_query($conn, "UPDATE users SET gezi_puani = GREATEST(0, gezi_puani - 5) WHERE id = $user_id");
        $status = 'unliked';
    }

    // 4. Güncel Beğeni Sayısını Hesapla
    $sayac_sorgu = mysqli_query($conn, "SELECT COUNT(*) as toplam FROM likes WHERE post_id=$post_id");
    $sayac_veri = mysqli_fetch_assoc($sayac_sorgu);
    $toplam_begeni = isset($sayac_veri['toplam']) ? (int)$sayac_veri['toplam'] : 0;

    // JavaScript'e pürüzsüz yanıt döndürüyoruz
    echo json_encode([
        'success' => true, 
        'new_like_count' => $toplam_begeni,
        'status' => $status
    ]);
    exit();
} else {
    echo json_encode(['success' => false, 'error' => 'Geçersiz istek parametreleri.']);
    exit();
}
?>