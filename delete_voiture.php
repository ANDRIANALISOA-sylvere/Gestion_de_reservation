<?php 
session_start();
require "db.php";
require "security.php";
$id=$_GET['idvoit'];
$query=$connection->prepare("DELETE FROM voiture WHERE idvoit=?");
$query->execute(array($id));

header("location:voiture.php");
?>

 
