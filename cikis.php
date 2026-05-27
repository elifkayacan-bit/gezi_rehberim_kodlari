<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Tüm session verilerini sıfırla
$_SESSION = array();

// Session çerezlerini temizle
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Oturumu tamamen yok et
session_destroy();

// Ana sayfaya yönlendir
header("Location: index.php");
exit();
?>