<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'baglan.php';

// Beğenme aksiyonu
if (isset($_GET['action']) && $_GET['action'] == 'like' && isset($_GET['post_id'])) {
    if (!isset($_SESSION['username'])) {
        // Giriş yapmadıysa beğenemez, giriş sayfasına yolla
        header("Location: giris.php");
        exit();
    }

    $username = $_SESSION['username'];
    $post_id = intval($_GET['post_id']);

    // Kullanıcı ID bulma
    $u_sorgu = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
    $u_veri = mysqli_fetch_assoc($u_sorgu);
    $user_id = $u_veri['id'];

    // Daha önce beğenmiş mi kontrolü
    $kontrol = mysqli_query($conn, "SELECT * FROM likes WHERE user_id=$user_id AND post_id=$post_id");

    if (mysqli_num_rows($kontrol) == 0) {
        // Beğenmediyse beğeniyi ekle
        mysqli_query($conn, "INSERT INTO likes (user_id, post_id) VALUES ($user_id, $post_id)");
    } else {
        // Beğendiyse beğeniyi geri çek (Un-like)
        mysqli_query($conn, "DELETE FROM likes WHERE user_id=$user_id AND post_id=$post_id");
    }

    // Beğenme bittikten sonra geldiği sayfaya geri yönlendir
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
    // ÖRNEK: Kullanıcı bir gönderiyi başarıyla beğendiğinde (like action içi)
$kullanici_id = $_SESSION['user_id']; // Oturumdaki kullanıcı ID'si
mysqli_query($conn, "UPDATE users SET gezi_puani = gezi_puani + 5 WHERE id = $kullanici_id"); // Beğeniye 5 GP

// ÖRNEK: Kullanıcı yeni bir fotoğraf / keşif paylaştığında (insert post içi)
mysqli_query($conn, "UPDATE users SET gezi_puani = gezi_puani + 20 WHERE id = $kullanici_id"); // Paylaşıma 20 GP
}
?>