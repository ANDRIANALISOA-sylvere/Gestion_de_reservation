<?php
session_start();
require "db.php";
require "security.php";
$id=$_GET['idreserv'];

$sql=$connection->prepare("SELECT place as place FROM reserver WHERE idreserv=?");
$sql->execute(array($id));
$place=$sql->fetch()['place'];

$sql=$connection->prepare("SELECT idvoit as idvoit FROM reserver WHERE idreserv=?");
$sql->execute(array($id));
$idvoit=$sql->fetch()['idvoit'];

$query=$connection->prepare("DELETE FROM reserver WHERE idreserv=?");
$query->execute(array($id));

$occupation="non";
$update=$connection->prepare("UPDATE place SET occupation=? WHERE idvoit=? AND place=?");
$update->execute(array($occupation,$idvoit,$place));
 
header("location:reserver.php");
?>
	