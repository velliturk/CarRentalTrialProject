<?php
$sayfa = "index";
include('inc/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!(isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "6789")) {
    header("location:login.php");
}
$sorgu = $baglanti->prepare("select * from araclar where arac_id=:arac_id");
$sorgu->execute(['arac_id' => (int)$_GET["arac_id"]]);
$sonuc = $sorgu->fetch();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<main>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Araç Güncelle
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label>Marka</label>
                    <input type="text" name="marka" required class="form-control" value="<?= $sonuc["marka"] ?>">
                    <label>Model</label>
                    <input type="text" name="model" required class="form-control" value="<?= $sonuc["model"] ?>">
                    <label>Plaka</label>
                    <input type="text" name="plaka" required class="form-control" value="<?= $sonuc["plaka"] ?>">
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
    $guncelleSorgu = $baglanti->prepare("Update araclar set marka=:marka, model=:model, plaka=:plaka where arac_id=:arac_id");
    $guncelle = $guncelleSorgu->execute([
        'marka' => $_POST["marka"],
        'model' => $_POST["model"],
        'plaka' => $_POST["plaka"],
        'arac_id' => (int)$_GET["arac_id"]
    ]);

    if ($guncelle) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "<script> Swal.fire( {title:'Başarılı', text:'Aracınız Güncellenmiştir.',icon:'succes',confirmButtonText:'Kapat'} ).then((value)=>{
    if (value.isConfirmed) {window.location.href='araclar.php'}})</script>";
    }
}
?>
