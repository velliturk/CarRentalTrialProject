<?php
ob_start();
$sayfa = "index";
include('inc/header.php');
if(isset($_GET['kullanim_id'])) {
    $kullanim_id = $_GET['kullanim_id'];

    // Veritabanında ilgili aracı silin
    $sorgu = $baglanti->prepare("DELETE FROM arac_kullanimlari WHERE kullanim_id = ?");
    $sorgu->bindParam(1, $kullanim_id);
    $sorgu->execute();

    // Silme işlemi başarılıysa kullanıcıyı araclar.php sayfasına yönlendirin
    if ($sorgu->rowCount() > 0) {
        header("Location: randevular.php");
        exit();
    } else {
        echo "Randevu silinirken bir hata oluştu";
    }
} else {
    echo "Randevu ID parametresi bulunamadı";
}

if ($sorgu) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "<script> Swal.fire( {title:'Başarılı', text:'Randevu Silinmiştir.',icon:'succes',confirmButtonText:'Kapat'} ).then((value)=>{
    if (value.isConfirmed) {window.location.href='randevular.php'}})</script>";
}

// Veritabanı bağlantısını kapatın
$baglanti = null;
ob_end_flush(); // çıktı tamponlamayı sonlandır