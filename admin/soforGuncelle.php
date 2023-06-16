<?php
$sayfa = "index";
include('inc/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!(isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "6789")) {
    header("location:login.php");
}
$sorgu = $baglanti->prepare("select * from soforler where sofor_id=:sofor_id");
$sorgu->execute(['sofor_id' => (int)$_GET["sofor_id"]]);
$sonuc = $sorgu->fetch();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<main>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Şoför Güncelle
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label>İsim</label>
                    <input type="text" name="soforAd" required class="form-control" value="<?= $sonuc["ad"] ?>">
                    <label>Soyad</label>
                    <input type="text" name="soyAd" required class="form-control" value="<?= $sonuc["soyad"] ?>">
                    <label>Telefon Numarası</label>
                    <input type="text" name="tel-no" required class="form-control" value="<?= $sonuc["telno"] ?>">
                    <label>Mail</label>
                    <input type="text" name="mail" required class="form-control" value="<?= $sonuc["mail"] ?>">
                    <label>Adres</label>
                    <input type="text" name="adres" required class="form-control" value="<?= $sonuc["adres"] ?>">
                </div>
                <br>
                <input type="submit" value="Güncelle" class="btn btn-outline-secondary">
            </form>
        </div>
    </div>

</main>
<?php
$sayfa = "index";
include('inc/footer.php');
if ($_POST) { //Veri Güncelle
    $guncelleSorgu = $baglanti->prepare("Update soforler set ad=:ad, soyad=:soyad, telno=:telno, mail=:mail, adres=:adres where sofor_id=:sofor_id");
    $guncelle = $guncelleSorgu->execute([
        'ad' => $_POST["soforAd"],
        'soyad' => $_POST["soyAd"],
        'telno' => $_POST["tel-no"],
        'mail' => $_POST["mail"],
        'adres' => $_POST["adres"],
        'sofor_id' => (int)$_GET["sofor_id"]
    ]);

    if ($guncelle) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "<script> Swal.fire( {title:'Başarılı', text:'Şoför Bilgileri Güncellenmiştir.',icon:'success',confirmButtonText:'Kapat'} ).then((value)=>{
    if (value.isConfirmed) {window.location.href='soforler.php'}})</script>";
    }
}
?>