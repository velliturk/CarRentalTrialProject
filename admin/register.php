<?php
session_start();
include("../inc/vt.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kadi = $_POST["txtKadi"];
    $parola = $_POST["txtParola"];

    // Kullanıcıyı veritabanına ekleme işlemleri
    $sorgu = $baglanti->prepare("INSERT INTO kullanici (kadi, parola, yetki, aktif) VALUES (:kadi, :parola, :yetki, :aktif)");
    $sorgu->execute([
        'kadi' => $kadi,
        'parola' => md5("56" . $parola . "23"),
        'yetki' => 1, // Kullanıcı yetkisini burada belirleyebilirsiniz
        'aktif' => 1
    ]);

    // Kayıt başarılıysa oturum açma işlemi
    $_SESSION["Oturum"] = "6789";
    $_SESSION["kadi"] = $kadi;
    $_SESSION["yetki"] = 1; // Kullanıcı yetkisini burada belirleyebilirsiniz

    header("location:index.php"); // Yönlendirme yapılacak sayfayı burada belirleyebilirsiniz
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
    <title>Kayıt Ol - YP Admin</title>
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
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Kayıt Ol</h3></div>
                            <div class="card-body">
                                <form method="post" action="register.php">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputEmail" type="text" name="txtKadi" placeholder="Kullanıcı Adı" required/>
                                        <label for="inputEmail">Kullanıcı Adı</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputPassword" type="password" name="txtParola" placeholder="Şifre" required/>
                                        <label for="inputPassword">Şifre</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <a class="small" href="login.php">Giriş Yap</a>
                                        <input type="submit" class="btn btn-primary" value="Kayıt Ol">
                                    </div>
                                </form>
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
                    <div class="text-muted">Copyright &copy; Veli Türk</div>
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

