<?php 
    $id = $_SESSION['uyeid'];
    if (isset($_SESSION['oturum'])) {
            header("refresh:4;url=index.php?SK=2");
        
    }
    else{
        header("Location:index.php");
    }

    if(isset($_POST['arkadasekle'])){
        $alici_id = $_POST['arkadasekle'];
        $gonderen_id = $id;


        $check_sql = "SELECT * FROM arkadaslik WHERE gonderen_id = '$gonderen_id' AND alici_id = '$alici_id'";
        $result = $baglan->query($check_sql);
        if ($result->num_rows == 0) {
            // No record found, so insert new record
            $insert_sql = "INSERT INTO arkadaslik (gonderen_id, alici_id) VALUES ('$gonderen_id', '$alici_id' )";
            
            if ($baglan->query($insert_sql) === TRUE) {
                echo "<div>Arkadaşlık isteği gönderildi.<div/>";
                header("refresh:1;url=index.php?SK=2");
            } else {
                echo "Hata oluştu: " . $insert_sql . "<br>" . $baglan->$error;
            }
        } else {
            // Record already exists, so show an error message
            echo "<div>Bu arkadaşlık isteği zaten gönderilmiş.<div/>";
            header("refresh:1;url=index.php?SK=2");
        }
    }
    
if (isset($_POST["arkadasil"])) {
    # code...
    $gelen = $_POST['arkadasil'];
    $select = "DELETE  FROM arkadaslik WHERE arkadas_id = $gelen";
    $delete = mysqli_query($baglan,$select);
    if ($delete) {
        echo "<div >Silindi.<div/>";

        header("refresh:1;url=index.php?SK=2");
    }
}
if(isset($_POST['arkadaseklen'])){
    $gelenid = $_POST['arkadaseklen'];
    echo $gelenid;
    $select = "UPDATE arkadaslik SET durum = '2' WHERE arkadas_id  = '$gelenid' or arkadas_id='$id'";
    $update = mysqli_query($baglan , $select);
    if ($update) {
        echo "<div >Başarıyla Eklendi.<div/>";
        header("refresh:1;url=index.php?SK=2");

    }
}


?>

    <h2 style="font-size:40px;">Takip Et</h2>
    <div style="width:100%;height:2px;background-color: black;"></div>
    <span style="font-size:25px;">Kullanıcı Adı</span>
    <div style="width:100%;height:1px;background-color: black;"></div>
    <br>
    <div class="arkadas-istekleri-page">
<?php
    $select = " SELECT * FROM user WHERE uye_id != '$id'";
    $result=mysqli_query($baglan,$select);
    while($row = mysqli_fetch_array($result)){
        if (mysqli_num_rows($result) > 0) {

        
?>
        <form action="" method="post">
            <img src="img/<?php echo $row['uye_resmi'];?>" alt="" height="70" width="70" style="position:relative;border-radius:50px;">
            <span style="font-size:30px;position:relative;bottom:1.5rem;left:1rem;"><?php echo $row['uye_kullaniciadi'];?></span>
            <button name="arkadasekle" value="<?php echo $row['uye_id'];?>" style="background-color: rgb(0, 168, 132);color:white;height:30px;width:100px;position:absolute;right:2rem;margin-top:1rem;cursor:pointer">
                            Takip Et
            </button>
            <div style="height:1rem;"></div>
        </form>


<?php
}}?>
</div>

<div class="arkadas-istekleri">
    <h2>Takip İstekleri</h2>
    <div style="width:100%;height:2px;background-color: black;"></div>

    
    
<?php 
    $id = $_SESSION['uyeid'];
    $select  = mysqli_query($baglan, "SELECT * FROM arkadaslik INNER JOIN user ON user.uye_id = arkadaslik.gonderen_id WHERE (alici_id = $id or gonderen_id= $id) and durum='0' ");

    while ($row = mysqli_fetch_assoc($select)) {
        if ($row["alici_id"] == "$id") {
            # code...
          
?>

<div class="arkadaslar_bilgi">
    <form action="" method="post">
    <img src="img/<?php echo $row['uye_resmi'];?>" alt="" height="70" width="70" style="position:relative;border-radius:50px; margin-top:10px;">
    <span style="font-size:30px;position:relative;bottom:1.5rem;left:1rem;"><?php echo $row['uye_kullaniciadi'];?></span>

                        <button name="arkadaseklen" value="<?php echo $row['arkadas_id'];?>" style="cursor:pointer;color:white;background-color: rgb(0, 168, 132);height:30px;width:100px;position:absolute;right:140px;margin-top:1.5rem;">
                            Kabul Et
                        </button>
                        <button name="arkadasil" value="<?php echo $row['arkadas_id'];?>" style="cursor:pointer;color:white;background-color: rgb(0, 168, 132);;height:30px;width:100px;position:absolute;right:2rem;margin-top:1.5rem;">
                            Sil
                        </button>
                        <hr style="border:1px dashed ">

    </form>
</div>

<?php }}?>
</div>
