<?php 
    $uyeid = $_SESSION['uyeid'];
    if (isset($_POST['guncelle'])) {
        $uyeresmi = $_FILES["uye_resmi"]['name'];
        $uyeresmi_tmp_name = $_FILES["uye_resmi"]["tmp_name"];
        $uyeresmi_folder = "img/".$uyeresmi;
        copy($uyeresmi_tmp_name, 'img/' . $uyeresmi);
        $email = $_POST['email'];
        $kullaniciadi = $_POST['kullaniciadi'];
        $sifre = $_POST['sifre'];
        if (empty($uyeresmi) or empty($email) or empty($kullaniciadi) or empty($sifre)) {
            echo "Lütfen boş alan bırakmayınız.";
        }else{
            try{
                $insert = "UPDATE user SET uye_email = '$email' ,uye_kullaniciadi = '$kullaniciadi',uye_sifre='$sifre',uye_resmi='$uyeresmi' 
                 WHERE uye_id =$uyeid ";
                $upload = mysqli_query($baglan , $insert);
                if ($upload) {
                    
                    move_uploaded_file($uyeresmi,$uyeresmi_folder);
                    echo "Güncellendi";
                }
                else
                {
                    echo "Ürün eklenirken hatayla karşılaştı.";
                }
            }
            catch(Exception $e){
                echo "<br><br><br><br><br><br>".$e;
            }
        }

    }
    $select  = mysqli_query($baglan, "SELECT * FROM user WHERE uye_id = $uyeid");
    while ($row = mysqli_fetch_array($select)) {
?>
<div class="hesabim-page">
    <div class="hesabim-bilgiler">
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                <h3 style="position: relative; font-size:40px;bottom:300px;right:100px;">Hesap Bilgileri</h3>
                <p style="position: relative; font-size:30px;bottom:280px; right:100px;">Hesap bilgilerini bu alandan görüntüleyebilir, güncelleyebilirsiniz.</p>
                <img src="img/<?php echo $row['uye_resmi']; ?>" height="100" width="100" style="border-radius: 20px; position:absolute;top:250px;">
                <span style="position:absolute;top:250px;right:440px;">Resmi güncellemek için dosya yükleyebilirsiniz!!.</span>
                <input type="file" name="uye_resmi" accept="image/png, image/jpeg, image/jpg" style="border:0;">
                <input type="email" placeholder="<?php echo $row['uye_email'];?>" name="email"><br>
                <input type="text" placeholder="<?php echo $row['uye_kullaniciadi'];?>" name="kullaniciadi"><br>
                <input type="password" placeholder="<?php echo $row['uye_sifre'];?>" name="sifre"><br>
                <button name="guncelle">Güncelle</button>

            </form>
    </div>
</div>

<?php
    }
?>