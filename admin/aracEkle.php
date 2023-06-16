<?php
ob_start();
include('inc/header.php');
if (!(isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "6789")) {
    header("location:login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marka = $_POST["marka"];
    $model = $_POST["model"];
    $yakitDurumu = $_POST["yakitDurumu"];
    $durum = $_POST["durum"];
    $plaka = $_POST["plaka"];

    $sorgu = $baglanti->prepare("INSERT INTO araclar (marka, model, yakitDurumu, plaka) VALUES (?, ?, ?, ?)");
    $sorgu->execute([$marka, $model, $yakitDurumu, $plaka]);

    header("location:araclar.php");
}
?>
<main>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Araç Ekle
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="marka">Marka:</label>
                    <input type="text" class="form-control" id="marka" name="marka" required>
                </div>
                <div class="form-group">
                    <label for="model">Model:</label>
                    <input type="text" class="form-control" id="model" name="model" required>
                </div>
                <div class="form-group">
                    <label for="yakitDurumu">Yakıt Durumu:</label>
                    <input type="number" class="form-control" id="yakitDurumu" name="yakitDurumu" min="0" max="100" required>
                </div>
                <!--<div class="form-group">
                    <label for="durum">Durum:</label>
                    <select class="form-control" id="durum" name="durum" required>
                        <option value="Mevcut">Mevcut</option>
                        <option value="Kirada">Kirada</option>
                        <?php
/*                        if ($_POST["durum"] == "Mevcut") {
                        $durum = true;
                        } else {
                        $durum = false;
                        } */?>
                    </select>
                </div>-->
                <div class="form-group">
                    <label for="plaka">Plaka:</label>
                    <input type="text" class="form-control" id="plaka" name="plaka" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Ekle</button>
            </form>
        </div>
    </div>
</main>
<?php
$sayfa = "aracEkle";
include('inc/footer.php');
ob_end_flush();
?>
