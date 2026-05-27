<?php
// Veritabanı bağlantı dosyanı dahil et (Adı baglan.php değilse config.php veya conn.php yap)
include 'baglan.php'; 
session_start();

if (isset($_GET['id']) && isset($_SESSION['username'])) {
    $gonderi_id = intval($_GET['id']);
    
    // gonderiler tablosundaki ilgili keşfin beğeni sayısını 1 artırıyoruz
    $guncelle = mysqli_query($conn, "UPDATE gonderiler SET begeni_sayisi = begeni_sayisi + 1 WHERE id = $gonderi_id");
}

// Kullanıcıyı butona tıkladığı sayfaya (örneğin profile geri) otomatik yönlendirir
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: index.php");
}
exit();
?>