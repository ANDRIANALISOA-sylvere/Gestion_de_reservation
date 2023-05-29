<?php 
if (!isset($_SESSION['login'])) {
	header("location:login.php");
}
 ?>