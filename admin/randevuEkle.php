<?php
ob_start();
include "inc/header.php";

// Query the database to get the list of vehicles
$sorgu = $baglanti->prepare("SELECT arac_id, plaka FROM araclar");
$sorgu->execute();
$araclar = $sorgu->fetchAll(PDO::FETCH_ASSOC);

$sorgu = $baglanti->prepare("SELECT sofor_id, ad FROM soforler");
$sorgu->execute();
$soforler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $arac_id = $_POST["arac_id"];
    $sofor_id = $_POST["sofor_id"];
    $baslangic_tarihi = $_POST['baslangic_tarihi'];
    $bitis_tarihi = $_POST['bitis_tarihi'];
    $kullanim_sehri = $_POST['kullanim_sehri'];
    $tutar = $_POST['tutar'];

    // Calculate the number of days between start date and end date
    $baslangic = new DateTime($baslangic_tarihi);
    $bitis = new DateTime($bitis_tarihi);
    $gun_sayisi = $bitis->diff($baslangic)->days;

    // Calculate the total price based on the daily rate and number of days
    $toplam_tutar = $tutar * $gun_sayisi;

    // Check if the selected vehicle has an existing appointment until the end date
    $sorgu = $baglanti->prepare("SELECT * FROM arac_kullanimlari WHERE arac_id = :arac_id AND bitis_tarihi > :baslangic_tarihi");
    $sorgu->execute(['arac_id' => $arac_id, 'baslangic_tarihi' => $baslangic_tarihi]);
    $randevu_varmi = $sorgu->fetch();

    if ($randevu_varmi) {
        echo "Seçilen araç için belirtilen tarihler arasında başka bir randevu bulunmaktadır.";
    } else {
        // Insert the new appointment into the database
        $sorgu = $baglanti->prepare("INSERT INTO arac_kullanimlari (arac_id, sofor_id, baslangic_tarihi, bitis_tarihi, kullanim_sehri, tutar) VALUES (:arac_id, :sofor_id, :baslangic_tarihi, :bitis_tarihi, :kullanim_sehri, :tutar)");
        $sorgu->bindParam(':arac_id', $arac_id);
        $sorgu->bindParam(':sofor_id', $sofor_id);
        $sorgu->bindParam(':baslangic_tarihi', $baslangic_tarihi);
        $sorgu->bindParam(':bitis_tarihi', $bitis_tarihi);
        $sorgu->bindParam(':kullanim_sehri', $kullanim_sehri);
        $sorgu->bindParam(':tutar', $toplam_tutar);

        if ($sorgu->execute()) {
            header("location:randevular.php");
        } else {
            echo "Randevu eklenirken hata oluştu.";
        }
    }
}
?>

<main>
    <div class="card mb-4">
        <div class="card-body">
            <h2>Randevu Oluştur</h2>
            <form method="post">
                <div class="form-group">
                    <label for="ad">Araç Plakası</label>
                    <select name="arac_id" id="arac_id" class="form-control">
                        <?php
                        foreach ($araclar as $arac) {
                            echo "<option value='" . $arac['arac_id'] . "'>" . $arac['plaka'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sofor_id">Şoför Seçimi:</label>
                    <select name="sofor_id" id="sofor_id" class="form-control">
                        <?php
                        foreach ($soforler as $sofor) {
                            echo "<option value='" . $sofor['sofor_id'] . "'>" . $sofor['ad'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="telno">Randevu Başlama Tarihi</label>
                    <input type="date" name="baslangic_tarihi" id="baslangic_tarihi" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="telno">Randevu Bitiş Tarihi</label>
                    <input type="date" name="bitis_tarihi" id="bitis_tarihi" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="mail">Araç Teslim Şehri</label>
                    <input type="text" class="form-control" id="kullanim_sehri" name="kullanim_sehri" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="tutar">Günlük Tutar</label>
                    <input type="number" step="0.01" class="form-control" id="tutar" name="tutar" required>
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
