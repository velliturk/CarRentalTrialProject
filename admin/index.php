<?php
ob_start();
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

$sorgu = $baglanti->prepare("SELECT ak.kullanim_id, a.plaka,a.marka,a.model, s.ad, s.soyad, ak.baslangic_tarihi, ak.bitis_tarihi, ak.kullanim_sehri FROM arac_kullanimlari ak INNER JOIN araclar a ON ak.arac_id = a.arac_id INNER JOIN soforler s ON ak.sofor_id = s.sofor_id");
$sorgu->execute();
$sonuc = $sorgu->fetchAll();

// Yıllık kullanım özeti için verileri almak için sorgu yapın
// Örnek randevu bilgileri (tablo verisi)
$sorgu = $baglanti->prepare("SELECT arac_id, baslangic_tarihi, bitis_tarihi FROM arac_kullanimlari");
$sorgu->execute();
$randevular = $sorgu->fetchAll(PDO::FETCH_ASSOC);

// Yıllık En Çok Kullanılan Araba ve En Az Kullanılan Araba İstatistikleri
$sorgu = $baglanti->prepare("SELECT a.plaka, COUNT(*) AS kullanım_sayısı
                            FROM arac_kullanimlari ak
                            INNER JOIN araclar a ON ak.arac_id = a.arac_id
                            WHERE YEAR(ak.baslangic_tarihi) = YEAR(NOW())
                            GROUP BY ak.arac_id
                            ORDER BY kullanım_sayısı DESC
                            LIMIT 1");
$sorgu->execute();
$enCokKullanilanAraba = $sorgu->fetch(PDO::FETCH_ASSOC);

$sorgu = $baglanti->prepare("SELECT a.plaka, COUNT(*) AS kullanım_sayısı
                            FROM arac_kullanimlari ak
                            INNER JOIN araclar a ON ak.arac_id = a.arac_id
                            WHERE YEAR(ak.baslangic_tarihi) = YEAR(NOW())
                            GROUP BY ak.arac_id
                            ORDER BY kullanım_sayısı ASC
                            LIMIT 1");
$sorgu->execute();
$enAzKullanilanAraba = $sorgu->fetch(PDO::FETCH_ASSOC);
?>

<?php
// Aylık En Çok Kullanılan Araba ve En Az Kullanılan Araba İstatistikleri
$sorgu = $baglanti->prepare("SELECT a.plaka, COUNT(*) AS kullanım_sayısı
                            FROM arac_kullanimlari ak
                            INNER JOIN araclar a ON ak.arac_id = a.arac_id
                            WHERE YEAR(ak.baslangic_tarihi) = YEAR(NOW()) AND MONTH(ak.baslangic_tarihi) = MONTH(NOW())
                            GROUP BY ak.arac_id
                            ORDER BY kullanım_sayısı DESC
                            LIMIT 1");
$sorgu->execute();
$enCokKullanilanArabaAylik = $sorgu->fetch(PDO::FETCH_ASSOC);

$sorgu = $baglanti->prepare("SELECT a.plaka, COUNT(*) AS kullanım_sayısı
                            FROM arac_kullanimlari ak
                            INNER JOIN araclar a ON ak.arac_id = a.arac_id
                            WHERE YEAR(ak.baslangic_tarihi) = YEAR(NOW()) AND MONTH(ak.baslangic_tarihi) = MONTH(NOW())
                            GROUP BY ak.arac_id
                            ORDER BY kullanım_sayısı ASC
                            LIMIT 1");
$sorgu->execute();
$enAzKullanilanArabaAylik = $sorgu->fetch(PDO::FETCH_ASSOC);

?>
<main>
<!-- Page Content -->
<div class="container">
    <h1 class="mt-4">İstatistikler</h1>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Yıllık En Çok Kullanılan Araba
                </div>
                <div class="card-body">
                    <h5><?php echo $enCokKullanilanAraba['plaka']; ?></h5>
                    <p>Kullanım Sayısı: <?php echo $enCokKullanilanAraba['kullanım_sayısı']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Yıllık En Az Kullanılan Araba
                </div>
                <div class="card-body">
                    <h5><?php echo $enAzKullanilanAraba['plaka']; ?></h5>
                    <p>Kullanım Sayısı: <?php echo $enAzKullanilanAraba['kullanım_sayısı']; ?></p>
                </div>
            </div>
        </div>


        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Aylık En Çok Kullanılan Araba
                </div>
                <div class="card-body">
                    <h5><?php echo $enCokKullanilanArabaAylik['plaka']; ?></h5>
                    <p>Kullanım Sayısı: <?php echo $enCokKullanilanArabaAylik['kullanım_sayısı']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Aylık En Az Kullanılan Araba
                </div>
                <div class="card-body">
                    <h5><?php echo $enAzKullanilanArabaAylik['plaka']; ?></h5>
                    <p>Kullanım Sayısı: <?php echo $enAzKullanilanArabaAylik['kullanım_sayısı']; ?></p>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Randevu Bilgilendirme Özet
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Araç</th>
                        <th>Plaka</th>
                        <th>Kiralayan Kişi</th>
                        <th>Kullanım Süresi</th>
                        <th>Randevu Bitiş Tarihi</th>
                        <th>Kiralama Şehri</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($randevular as $randevu) : ?>
                        <?php foreach ($sonuc as $randevular) { ?>
                            <tr>
                                <td><?php echo $randevular["marka"] . " " . $randevular["model"] ?></td>
                                <td><?php echo $randevular["plaka"]; ?></td>
                                <td><?php echo $randevular["ad"] . " " . $randevular["soyad"]; ?></td>
                                <?php
                                $baslangicTarihi = new DateTime($randevular["baslangic_tarihi"]);
                                $bitisTarihi = new DateTime($randevular["bitis_tarihi"]);
                                $gunFarki = $bitisTarihi->diff($baslangicTarihi)->format('%a');
                                ?>
                                <td><?php echo $gunFarki . " " . "Gün"; ?></td>
                                <td><?php echo $randevular["bitis_tarihi"]; ?></td>
                                <td><?php echo $randevular["kullanim_sehri"]; ?></td>
                            </tr>
                        <?php } ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php
$sayfa = "soforEkle";
include('inc/footer.php');
ob_end_flush();
?>