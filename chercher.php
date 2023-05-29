<?php 
session_start();
require "db.php";
require "security.php";

if (isset($_GET['valider'])) {
	if (!empty($_GET['chercher']) AND !empty($_GET['cherchervoit'])) {
	
	$recherche=$_GET['chercher'];
	$recherchevoit=$_GET['cherchervoit'];


	$sql='SELECT nom,numtel,montant_avance,payement FROM client,reserver WHERE reserver.idcli=client.idcli AND reserver.payement=:a AND reserver.idvoit=:b';
	$donne=$connection->prepare($sql);
	$donne->bindValue(':a',$recherche,PDO::PARAM_STR);
	$donne->bindValue(':b',$recherchevoit,PDO::PARAM_STR);
	$donne->execute();

	$req='SELECT count(*) as total FROM client,reserver where client.idcli=reserver.idcli AND reserver.payement=:p AND reserver.idvoit=:i';
	$data=$connection->prepare($req);
	$data->bindValue(':p',$recherche,PDO::PARAM_STR);
	$data->bindValue(':i',$recherchevoit,PDO::PARAM_STR);
	$data->execute();
	$total=$data->fetch()['total'];

	$query='SELECT frais as frais from voiture where idvoit=:p';
	$datafrais=$connection->prepare($query);
	$datafrais->bindValue(':p',$recherchevoit,PDO::PARAM_STR);
	$datafrais->execute();
	$frais=$datafrais->fetch()['frais'];

	}else
	{
		$erreur="Veuillez séléctionner une voiture";

	} 
}	
 ?>
<?php 
    $sqlvoit=$connection->prepare("SELECT * FROM voiture");
    $sqlvoit->execute();
 ?>
<?php
require "header.php";
require "navbar.php";
?>
<div class="container">
	<div class="row">
	<div class="col-md-7">
		<?php if($sqlvoit->rowCount()==0):?>
			<div class="alert alert-danger text-center alert-dismissible fade show"role="alert">
	            <strong>Il n'y a pas de voiture dans la base de données.</strong>
	            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        	</div>
        <?php elseif(isset($erreur)):?>
        	<div class="alert alert-danger text-center alert-dismissible fade show"role="alert">
	            <strong><?php echo $erreur; ?></strong>
	            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        	</div>
        <?php else: ?>
		<table class="table table-bordered container text-center">
			<thead class="bg-primary text-light">
				<tr>
					<th>Nom</th>
					<th>Numéro téléphone</th>
					<th>Reste</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($donne)):?>
					<?php if($donne->rowCount()==0):?>
						<div class="alert alert-danger text-center alert-dismissible fade show"role="alert">
							<strong>Aucune voyageur correspondant à votre recherche</strong>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<?php if(isset($donne)):?>
					<?php while($valeur=$donne->fetch()):?>
						<tr>
							<td><?php echo $valeur['nom']; ?></td>
							<td><?php echo $valeur['numtel']; ?></td>
							<td><?php if ($valeur['payement']=="tout payé") {
								echo "0 Ar";
							}else
							{
								echo $frais-$valeur['montant_avance']." Ar";
							}
							?></td>
						</tr>
					<?php endwhile; ?>
				<?php endif; ?>
			</tbody>
		</table>
	<?php endif; ?>
	</div>
	<?php if($sqlvoit->rowCount()==0):?>

	<?php elseif(isset($erreur)):?>
	
	<?php else: ?>
		<div class="col-md-5">
			<div class="card border">
				<div class="card-header text-center border-bottom bg-dark text-light">
					Total des voyageurs correspondant
				</div>
				<div class="card-body text-center">
					<?php if(isset($total)):?>
						<h3><?php echo $total; ?> voyageur(s)</h3>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>
</div>
<?php require "footer.php"; ?>