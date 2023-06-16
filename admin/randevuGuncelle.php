<?php
$sayfa = "index";
include('inc/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!(isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "6789")) {
    header("location:login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanim_id = $_POST["kullanim_id"];
    $arac_id = $_POST["arac_id"];
    $sofor_id = $_POST["sofor_id"];
    $baslangic_tarihi = $_POST["baslangic_tarihi"];
    $bitis_tarihi = $_POST["bitis_tarihi"];
    $kullanim_sehri = $_POST["kullanim_sehri"];

    $guncelleSorgu = $baglanti->prepare("UPDATE arac_kullanimlari SET arac_id = :arac_id, sofor_id = :sofor_id, baslangic_tarihi = :baslangic_tarihi, bitis_tarihi = :bitis_tarihi, kullanim_sehri = :kullanim_sehri WHERE kullanim_id = :kullanim_id");
    $guncelle = $guncelleSorgu->execute([
        'arac_id' => $arac_id,
        'sofor_id' => $sofor_id,
        'baslangic_tarihi' => $baslangic_tarihi,
        'bitis_tarihi' => $bitis_tarihi,
        'kullanim_sehri' => $kullanim_sehri,
        'kullanim_id' => $kullanim_id
    ]);

    if ($guncelle) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "<script> Swal.fire( {title:'Başarılı', text:'Randevu Bilgileri Güncellenmiştir.',icon:'success',confirmButtonText:'Kapat'} ).then((value)=>{
    if (value.isConfirmed) {window.location.href='randevular.php'}})</script>";
    }
}

// Randevu bilgilerini çekme
if (isset($_GET["kullanim_id"])) {
    $kullanim_id = $_GET["kullanim_id"];

    $sorgu = $baglanti->prepare("SELECT * FROM arac_kullanimlari WHERE kullanim_id = :kullanim_id");
    $sorgu->execute(['kullanim_id' => $kullanim_id]);
    $sonuc = $sorgu->fetch();

    if (!$sonuc) {
        header("location:randevular.php");
    }
} else {
    header("location:randevular.php");
}
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
                    <label>Araç Plakası</label>
                    <select name="arac_id" required class="form-control">
                        <?php
                        $arac_sorgu = $baglanti->prepare("SELECT * FROM araclar");
                        $arac_sorgu->execute();
                        $araclar = $arac_sorgu->fetchAll();

                        foreach ($araclar as $arac) {
                            echo "<option value='" . $arac["arac_id"] . "' " . ($sonuc["arac_id"] == $arac["arac_id"] ? "selected" : "") . ">" . $arac["plaka"] . "</option>";
                        }
                        ?>
                    </select>
                    <label>Şoför Adı</label>
                    <select name="sofor_id" required class="form-control">
                        <?php
                        $sofor_sorgu = $baglanti->prepare("SELECT * FROM soforler");
                        $sofor_sorgu->execute();
                        $soforler = $sofor_sorgu->fetchAll();

                        foreach ($soforler as $sofor) {
                            echo "<option value='" . $sofor["sofor_id"] . "' " . ($sonuc["sofor_id"] == $sofor["sofor_id"] ? "selected" : "") . ">" . $sofor["ad"] . "</option>";
                        }
                        ?>
                    </select>
                    <label>Randevu Başlangıç Tarihi</label>
                    <input type="date" name="baslangic_tarihi" required class="form-control" value="<?= $sonuc["baslangic_tarihi"] ?>">
                    <label>Randevu Bitiş Tarihi</label>
                    <input type="date" name="bitis_tarihi" required class="form-control" value="<?= $sonuc["bitis_tarihi"] ?>">
                    <label>Kullanım Şehri</label>
                    <input type="text" name="kullanim_sehri" required class="form-control" value="<?= $sonuc["kullanim_sehri"] ?>">
                </div>
                <br>
                <input type="hidden" name="kullanim_id" value="<?= $sonuc["kullanim_id"] ?>">
                <input type="submit" value="Güncelle" class="btn btn-outline-secondary">
            </form>
        </div>
    </div>
</main>

<?php
$sayfa = "index";
include('inc/footer.php');
?>
