<?php
session_start();
include("../inc/vt.php");

// Log kaydını ekle
if (isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "6789") {
    $user_id = $_SESSION["kadi"];
    $ip_address = $_SERVER["HTTP_CLIENT_IP"] ?? $_SERVER["HTTP_X_FORWARDED_FOR"] ?? $_SERVER["REMOTE_ADDR"];
    $action = "Çıkış yapıldı";

    // Kullanıcı ID'sini almak için kullanıcı tablosundan sorgu yap
    $sorgu = $baglanti->prepare("SELECT id FROM kullanici WHERE kadi = :kadi");
    $sorgu->execute(['kadi' => $user_id]);
    $sonuc = $sorgu->fetch();
    if ($sonuc) {
        $user_id = $sonuc["id"];

        // Log kaydını ekle
        $sorgu = $baglanti->prepare("INSERT INTO log (user_id, ip_address, action) VALUES (:user_id, :ip_address, :action)");
        $sorgu->execute(['user_id' => $user_id, 'ip_address' => $ip_address, 'action' => $action]);
    }
}

// Oturumu sonlandır
session_destroy();
setcookie("cerez", "", time() - 1);
header("location:login.php");
