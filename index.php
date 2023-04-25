<?php
require_once("db/db.php");
require_once("sayfalar/sayfa.php");


if (!$_SESSION['oturum']) {
    header("Location:user/login.php");
}

if (isset($_REQUEST["SK"])) {
    $SayfaKoduDegeri = $_REQUEST["SK"];
} else {
    $SayfaKoduDegeri = 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="arkaplan-yesil"></div>
    <div class="main-page">
        <div class="main-left">
            <div class="navbar">
  <?php              
    $uyeid = $_SESSION['uyeid'];

    $select  = mysqli_query($baglan, "SELECT * FROM user WHERE uye_id = $uyeid");
    while ($row = mysqli_fetch_array($select)) {
      
?>
                <a href="index.php?SK=1" style="position: absolute; left:0;top:10px;"><img src="img/<?php echo $row['uye_resmi'];?>" 
                alt="" height="42" width="42" class="user_img"></a>

                <?php } ?>
                <?php 
                  
if (isset($_SESSION['oturum'])) {

$id = $_SESSION['uyeid'];
$select = " SELECT count(*) as toplam FROM arkadaslik WHERE alici_id = '$id' AND durum = 0";
$result = mysqli_query($baglan, $select);
$row = mysqli_fetch_array($result);

?><!---Arkadaş isteği--><span style="font-size: 20px;"><?php echo $row['toplam'];?></span>
<?php }?>
                <a href="index.php?SK=2"><img src="img/person-fill-add.svg" alt="" height="32" width="32"></a><!---MESAJ-->1
                <a href=""><img src="img/chat-left-text-fill.svg" alt="" height="22" width="22"></a>
                <a href="exit.php"><img src="img/box-arrow-right.svg" alt="" height="32" width="32"></a>
            </div>
            <div class="search">
                <form action="">
                    
                    <input type="text"><img src="img/search.svg" alt="" height="25">
                    <button>Ara</button>
                </form>
            </div>
            <div class="kisiler">
            <?php 
    $id = $_SESSION['uyeid'];
    $select  = mysqli_query($baglan, "SELECT * FROM arkadaslik LEFT JOIN user ON (user.uye_id = arkadaslik.gonderen_id OR user.uye_id = arkadaslik.alici_id) 
    WHERE (alici_id = $id OR gonderen_id = $id) AND durum='2' AND user.uye_id != $id");

    while ($row = mysqli_fetch_assoc($select)) {
        if ($row["alici_id"] == "$id" ) {
?>
<a href="">
                        <div class="kisi">
                            <img src="img/<?php echo $row['uye_resmi'];?>" height="45" width="45">
                            <div class="icerik">
                                <h2><?php echo $row['uye_kullaniciadi'];?></h2>
                                <p style="color: gray;">Sohbeti görmek için tıklayınız.</p>
                                <a href="" class="cop"><img src="img/trash3-fill.svg" height="30" width="30"    title="Arkadaşı sil"></a>
                            </div>
                        </div>
                </a>
                <hr style="width: 100%;height: 5px;">
<?php }}?>
            </div>
        </div>


        <div class="main-right">
        <?php
if ((!$SayfaKoduDegeri) or ($SayfaKoduDegeri == "") or ($SayfaKoduDegeri == 0)) {
   ?>
                <div class="right_icerik">
                    <img src="img/Screenshot_4.png" alt="">
                    <div class="right_metin">
                    <h1>ChatApp Web</h1>
                    <p>Online olarak arkadaşlarınıza mesaj gönderebilir ve alabilirsiniz.<br>Arkadaşları ekleyebilir ne paylaştıklarını görebilirsiniz.</p>
                    </div>    
                </div>

<?php
} else {
    include($Sayfa[$SayfaKoduDegeri]);
}
?>
                
        </div>
    </div>
</body>
</html>