<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "gezi_rehberim_db";

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die("Veritabanı bağlantı hatası: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
?>