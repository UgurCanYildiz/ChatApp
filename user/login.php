
<?php
require_once("../db/db.php");

if(isset($_POST['register'])){
    $email = $_POST['email'];
    $kullaniciadi = $_POST['kullaniciadi'];
    $sifre = $_POST['sifre'];
    $sifreo = $_POST['sifreo'];
    if ($email == "" or $kullaniciadi =="" or $sifre=="" or $sifreo =="") {
       echo "Lütfen Boş alan bırkmayınız!.";

    }else{
        if ($sifre == $sifreo) {
            $ekle = ("INSERT INTO `user` (`uye_email`, `uye_kullaniciadi`, `uye_sifre` ,`uye_resmi` )
             VALUES ('$email', '$kullaniciadi', '$sifre' , 'img-person.png');");
            $add = mysqli_query($baglan , $ekle);
            if ($add) {
                # Başarıyla Eklendi
                echo "Eklendi";
                header("refresh:1;url=login.php");


            } else{
                #Eklenirken hatayla karşılaşıldı.
                echo "Bir hatayla karşılaşıldı lütfen daha sonra tekrar dene.";
            }
        }
        else{
            //Şifreler Uyuşmuyor
            echo "Lütfen Şifreleri tekrar giriniz.";
        }
    }
}
if (isset($_POST['login'])) {
    $kullaniciadi = $_POST['kullaniciadi'];
    $sifre = $_POST['sifre'];
    if ($kullaniciadi =="" or $sifre=="") {
        echo "Lütfen Boş alan bırkmayınız!.";
    }
    else{
        $select = "SELECT * FROM user WHERE uye_kullaniciadi = '$kullaniciadi' && uye_sifre = '$sifre'";
        $cevap = mysqli_query($baglan , $select);
        if (mysqli_num_rows($cevap) > 0) {
            $row = mysqli_fetch_array($cevap);

            $_SESSION['oturum'] = true;
            $_SESSION['uyeid'] = $row['uye_id'];

            echo "Başarılı Giriş";
            header("refresh:1;url=../index.php");

        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="../style.css">

</head>
<body>
    <div class="arkaplan-yesil">
        <div class="login-page">
            <form action="" method="post">
                Kullanıcı Adı:<input type="text" name="kullaniciadi">
                Şifre: <input type="password" name="sifre">
                <button name="login">Giriş Yap</button>
            </form>
        </div>
    </div>
    <div class="register-page">
    <div class="register-text">
                <span style="color:white;font-size:85px;font-weight: bold;">Chat-wp</span><br>
                <span style="color:white;">tanıdıklarınla iletişim kurmanı ve hayatında olup bitenleri paylaşmanı sağlar.</span>
            </div>
        <div class="register-form">
            
            <form action="" method="post">
                <span>E mail</span> <input type="email" name="email"><hr> <br>
                <span>Kullanıcı Adı</span>  <input type="text" name="kullaniciadi"><hr><br>
                <span>Şifre</span> <input type="password" name="sifre"><hr><br>
                <span>Şifre Onayla</span> <input type="password" name="sifreo"><hr><br>
                <button name="register">Kayıt Ol</button>
            </form>
        </div>
    </div>
    

</body>
</html>