<?php
ob_start();
$sayfa = "index";
include('inc/header.php');
if(isset($_GET['arac_id'])) {
    $arac_id = $_GET['arac_id'];
    $sorgu = $baglanti->prepare("DELETE FROM araclar WHERE arac_id = ?");
    $sorgu->bindParam(1, $arac_id);
    $sorgu->execute();
    if ($sorgu->rowCount() > 0) {
        header("Location: araclar.php");
        exit();
    } else {
        echo "Arac silinirken bir hata oluştu";
    }
} else {
    echo "Arac ID parametresi bulunamadı";
}

if ($sorgu) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "<script> Swal.fire( {title:'Başarılı', text:'Aracınız Güncellenmiştir.',icon:'succes',confirmButtonText:'Kapat'} ).then((value)=>{
    if (value.isConfirmed) {window.location.href='araclar.php'}})</script>";
}
$baglanti = null;
ob_end_flush();