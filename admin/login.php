<?php
session_start();
include("../inc/vt.php");

if (isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "6789") {
    header("location:index.php");
} elseif (isset($_COOKIE["cerez"])) {
    $sorgu = $baglanti->prepare("SELECT id, kadi, yetki FROM kullanici WHERE aktif = 1");
    $sorgu->execute();
    while ($sonuc = $sorgu->fetch()) {
        if ($_COOKIE["cerez"] == md5("aa" . $sonuc["kadi"] . "bb")) {
            $_SESSION["Oturum"] = "6789";
            $_SESSION["kadi"] = $sonuc["kadi"];
            $_SESSION["yetki"] = $sonuc["yetki"];
            header("location:index.php");
        }
    }
}

if ($_POST) {
    $kadi = $_POST["txtKadi"];
    $parola = $_POST["txtParola"];

    $sorgu = $baglanti->prepare("SELECT id, parola, yetki FROM kullanici WHERE kadi = :kadi AND aktif = 1");
    $sorgu->execute(['kadi' => htmlspecialchars($kadi)]);
    $sonuc = $sorgu->fetch();

    if ($sonuc && md5("56" . $parola . "23") == $sonuc["parola"]) {
        $_SESSION["Oturum"] = "6789";
        $_SESSION["kadi"] = $kadi;
        $_SESSION["yetki"] = $sonuc["yetki"];

        if (isset($_POST["cbHatirla"])) {
            setcookie("cerez", md5("aa" . $kadi . "bb"), time() + (60 * 60 * 24 * 7));
        }

        // Log kaydını ekle
// Log kaydını ekle
        $user_id = $sonuc["id"];
        $ip_address = $_SERVER["HTTP_CLIENT_IP"] ?? $_SERVER["HTTP_X_FORWARDED_FOR"] ?? $_SERVER["REMOTE_ADDR"];
        $action = "Giriş yapıldı";
        $sorgu = $baglanti->prepare("INSERT INTO log (user_id, ip_address, action) VALUES (:user_id, :ip_address, :action)");
        $sorgu->execute(['user_id' => $user_id, 'ip_address' => $ip_address, 'action' => $action]);

        header("location:index.php");
    } else {
        echo "<script> Swal.fire('Hata','Bilgilerin Doğruluğundan Emin Olun ! ', 'error')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Giriş Yap - YP Admin</title>
    <link href="css/styles.css" rel="stylesheet"/>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Giriş Yap</h3></div>
                            <div class="card-body">
                                <form method="post" action="login.php">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputEmail" type="text" name="txtKadi"
                                               value="<?= @$_POST['txtKadi'] ?>"
                                               placeholder="name@example.com"/>
                                        <label for="inputEmail">Kullanıcı Adı</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputPassword" type="password" name="txtParola"
                                               placeholder="Password"/>
                                        <label for="inputPassword">Şifre</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                               name="cbHatirla"
                                               value=""/>
                                        <label class="form-check-label" for="inputRememberPassword">Beni Hatırla</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <a class="small" href="password.html">Şifremi Unuttum</a>
                                        <input type="submit" class="btn btn-primary" value="Giriş">
                                    </div>
                                </form>
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <div class="text-muted">&copy; Veli Türk</div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
