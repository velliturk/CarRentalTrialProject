<?php
$sayfa = "index";
include('inc/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!(isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "6789")) {
    header("location:login.php");
}
// Check if there are expired appointments and delete them
$sorgu = $baglanti->prepare("DELETE FROM arac_kullanimlari WHERE bitis_tarihi < CURDATE()");
$sorgu->execute();

$sorgu = $baglanti->prepare("SELECT ak.kullanim_id, a.plaka, s.ad, ak.baslangic_tarihi, ak.bitis_tarihi, ak.kullanim_sehri, ak.tutar FROM arac_kullanimlari ak INNER JOIN araclar a ON ak.arac_id = a.arac_id INNER JOIN soforler s ON ak.sofor_id = s.sofor_id");
$sorgu->execute();
$sonuc = $sorgu->fetchAll();
?>
<main>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Randevu Bilgileri
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                <tr>
                    <th>Kullanim Id</th>
                    <th>Araç</th>
                    <th>Soför</th>
                    <th>Randevu Başlangıç Tarihi</th>
                    <th>Randevu Bitiş Tarihi</th>
                    <th>Alınan Şehir</th>
                    <th>Toplam Tutar</th>
                    <th>Güncelle</th>
                    <th>Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($sonuc as $randevular) { ?>
                    <tr>
                        <td><?php echo $randevular["kullanim_id"]; ?></td>
                        <td><?php echo $randevular["plaka"]; ?></td>
                        <td><?php echo $randevular["ad"]; ?></td>
                        <td><?php echo $randevular["baslangic_tarihi"]; ?></td>
                        <td><?php echo $randevular["bitis_tarihi"]; ?></td>
                        <td><?php echo $randevular["kullanim_sehri"]; ?></td>
                        <td><?php echo $randevular["tutar"]; ?></td>
                        <td>
                            <a href="randevuGuncelle.php?kullanim_id=<?= $randevular["kullanim_id"] ?>" class="btn btn-primary">Güncelle</a>
                        </td>
                        <td>
                            <a href="randevuSil.php?kullanim_id=<?= $randevular["kullanim_id"] ?>" class="btn btn-danger">Sil</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php
$sayfa = "index";
include('inc/footer.php');
?>
