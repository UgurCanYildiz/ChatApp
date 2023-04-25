<?php 
require_once("db/db.php");

if (isset($_SESSION['oturum'])) {
    $id=$_SESSION['uyeid'];
        session_start();
        session_unset();
        session_destroy();
        
header("Location:index.php");
}



?>