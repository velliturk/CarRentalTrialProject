<?php
$sayfa = "index";
include('inc/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!(isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "6789")) {
    header("location:login.php");
}
$sorgu = $baglanti->prepare("select * from araclar");
$sorgu->execute();
$sonuc = $sorgu->fetchAll();
?>
<main>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Araç Bilgileri
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                <tr>
                    <th>Arac Id</th>
                    <th>Marka</th>
                    <th>Model</th>
                    <th>Yakıt Durumu</th>
                    <th>Durum</th>
                    <th>Plaka</th>
                    <th>Güncelle</th>
                    <th>Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($sonuc as $araclar) { ?>
                    <tr>
                        <td><?php echo $araclar["arac_id"]; ?></td>
                        <td><?php echo $araclar["marka"]; ?></td>
                        <td><?php echo $araclar["model"]; ?></td>
                        <td><?php echo "%" . $araclar["yakitDurumu"]; ?></td>
                        <td><?php echo $araclar["durum"]; ?></td>
                        <td><?php echo $araclar["plaka"]; ?></td>
                        <td><a href="aracGuncelle.php?arac_id=<?= $araclar["arac_id"] ?>" class="btn btn-primary ">Güncelle</a>
                        </td>
                        <td><a href="aracSil.php?arac_id=<?= $araclar["arac_id"] ?>"class="btn btn-danger ">Sil</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <a href="aracEkle.php" class="btn btn-info ">Araç Ekle</a>
        </div>
    </div>
</main>
<?php
$sayfa = "index";
include('inc/footer.php');
?>
