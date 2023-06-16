<?php
ob_start();
include "inc/header.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST["ad"];
    $soyad = $_POST["soyad"];
    $telno = $_POST["telno"];
    $mail = $_POST["mail"];
    $adres = $_POST["adres"];

    // Veritabanına yeni şoförü ekle
    $sorgu = $baglanti->prepare("INSERT INTO soforler (ad, soyad, telno, mail, adres) VALUES (:ad, :soyad, :telno, :mail, :adres)");
    $sorgu->bindParam(':ad', $ad);
    $sorgu->bindParam(':soyad', $soyad);
    $sorgu->bindParam(':telno', $telno);
    $sorgu->bindParam(':mail', $mail);
    $sorgu->bindParam(':adres', $adres);

    if ($sorgu->execute()) {
        header("location:soforler.php");
    } else {
        echo "Şoför eklenirken hata oluştu.";
    }
}
?>

<main>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Şoför Ekle
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="ad">İsim</label>
                    <input type="text" class="form-control" id="ad" name="ad" required>
                </div>
                <div class="form-group">
                    <label for="soyad">Soyad</label>
                    <input type="text" class="form-control" id="soyad" name="soyad" required>
                </div>
                <div class="form-group">
                    <label for="telno">Telefon Numarası</label>
                    <input type="tel" class="form-control" id="telno" name="telno" required>
                </div>
                <div class="form-group">
                    <label for="mail">Mail Adresi</label>
                    <input type="email" class="form-control" id="mail" name="mail" required>
                </div>
                <div class="form-group">
                    <label for="adres">Adres</label>
                    <textarea class="form-control" id="adres" name="adres" rows="3" required></textarea>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Ekle</button>
            </form>
        </div>
    </div>
</main>
<?php
$sayfa = "soforEkle";
include('inc/footer.php');
ob_end_flush();
?>

