<?php
$sayfa = "index";
include('inc/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!(isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "6789")) {
    header("location:login.php");
}
$sorgu = $baglanti->prepare("select * from soforler");
$sorgu->execute();
$sonuc = $sorgu->fetchAll();
?>
<main>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Şoför Bilgileri
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                <tr>
                    <th>Şoför Id</th>
                    <th>Şoför İsim</th>
                    <th>Şoför Soyad</th>
                    <th>Telefon Numarası</th>
                    <th>Mail Adresi</th>
                    <th>Adresi</th>
                    <th>Güncelle</th>
                    <th>Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($sonuc as $soforler) { ?>
                    <tr>
                        <td><?php echo $soforler["sofor_id"]; ?></td>
                        <td><?php echo $soforler["ad"]; ?></td>
                        <td><?php echo $soforler["soyad"]; ?></td>
                        <td><?php echo $soforler["telno"]; ?></td>
                        <td><?php echo $soforler["mail"]; ?></td>
                        <td><?php echo $soforler["adres"]; ?></td>
                        <td><a href="soforGuncelle.php?sofor_id=<?= $soforler["sofor_id"] ?>" class="btn btn-primary ">Güncelle</a>
                        </td>
                        <td><a href="soforSil.php?sofor_id=<?= $soforler["sofor_id"] ?>"
                               class="btn btn-danger ">Sil</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <a href="soforEkle.php" class="btn btn-info ">Şoför Ekle</a>
        </div>
    </div>

</main>
<?php
$sayfa = "index";
include('inc/footer.php');
?>
