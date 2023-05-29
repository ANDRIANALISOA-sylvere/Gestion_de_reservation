<?php 
try {
	$connection=new PDO("mysql:host=localhost;dbname=reservation","root","");
} catch (PDOException $e) {
	die("Erreur:".$e->getMessage());
}
 ?>