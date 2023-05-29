<?php 
session_start();
require "header.php";
require "navbar.php";
$acceuil=true;
?>
<div class="text-center mt-5">
	<img src="image/sad.png"height="100px;"><br><br>
	<strong class="text-danger">Oupsss!!!</strong>
	<p class="text-muted">Aucune réservation n'a été trouvée.</p><br>
	<a href="client.php"class="btn btn-outline-primary">Retourner</a>
</div>
 <?php require "footer.php"; ?>