<?php
ob_start();


// Logları ekrana yazdır


$sayfa = "index";
include('inc/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!(isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "6789")) {
    header("location:login.php");
}

$sorgu = $baglanti->prepare("SELECT * FROM log");
$sorgu->execute();
$loglar = $sorgu->fetchAll();

?>

    <body class="bg-primary">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Loglar</h3></div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kullanıcı ID</th>
                                        <th>IP Address</th>
                                        <th>Aksiyon</th>
                                        <th>Tarih</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($loglar as $log): ?>
                                        <tr>
                                            <td><?= $log['id'] ?></td>
                                            <td><?= $log['user_id'] ?></td>
                                            <td><?= $log['ip_address'] ?></td>
                                            <td><?= $log['action'] ?></td>
                                            <td><?= $log['log_tarih'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">YP Admin</div>
                </div>
            </div>
        </footer>
    </div>
</div>

<?php
$sayfa = "soforEkle";
include('inc/footer.php');
ob_end_flush();
?>