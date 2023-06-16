<?php
ob_start();
$sayfa = "index";
include('inc/header.php');
if(isset($_GET['sofor_id'])) {
    $sofor_id = $_GET['sofor_id'];

    // Veritabanında ilgili aracı silin
    $sorgu = $baglanti->prepare("DELETE FROM soforler WHERE sofor_id = ?");
    $sorgu->bindParam(1, $sofor_id);
    $sorgu->execute();

    // Silme işlemi başarılıysa kullanıcıyı araclar.php sayfasına yönlendirin
    if ($sorgu->rowCount() > 0) {
        header("Location: soforler.php");
        exit();
    } else {
        echo "Şoför silinirken bir hata oluştu";
    }
} else {
    echo "Sofor ID parametresi bulunamadı";
}

if ($sorgu) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "<script> Swal.fire( {title:'Başarılı', text:'Şoför Silinmiştir.',icon:'succes',confirmButtonText:'Kapat'} ).then((value)=>{
    if (value.isConfirmed) {window.location.href='soforler.php'}})</script>";
}

// Veritabanı bağlantısını kapatın
$baglanti = null;
ob_end_flush(); // çıktı tamponlamayı sonlandır