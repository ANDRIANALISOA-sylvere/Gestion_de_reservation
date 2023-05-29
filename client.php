<?php
session_start();
require "header.php";
require_once('navbar.php');
require_once('security.php'); ?>
<?php

	require_once('db.php');
	$sql='SELECT * FROM client ORDER BY idcli ASC';
	$data=$connection->prepare($sql);
	$data->execute();
	$articles=$data->fetchAll(PDO::FETCH_ASSOC);
	if (!empty($_GET['rechercher'])) {
		$rechecher=$_GET['rechercher'];
		$sql='SELECT * FROM client WHERE (nom LIKE "%'.$rechecher.'%") OR (numtel LIKE "%'.$rechecher.'%") ORDER BY idcli ASC';
		$data=$connection->prepare($sql);
		$data->execute();
		$articles=$data->fetchAll(PDO::FETCH_ASSOC);
	}
if(isset($_POST['valider']))
{
	if(!empty($_POST['nom']) && !empty($_POST['numtel']))
	{ 
		$nom=strip_tags($_POST['nom']);
		$numtel=strip_tags($_POST['numtel']);
		$sql="INSERT INTO client(nom,numtel)VALUES(:n,:num)";
		$article=$connection->prepare($sql);
		$article->bindValue(':n',$nom,PDO::PARAM_STR);
		$article->bindValue(':num',$numtel,PDO::PARAM_STR);
		$article->execute();
		header('Location: client.php');
	}
	else
	{
		$erreur="veuillez complétez tous les champs";
	}
}

?>
<div class="container">
    <?php if(isset($erreur)):?>
      <div class="alert alert-danger text-center alert-dismissible fade show"role="alert">
          <strong><?= $erreur ?></strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  <?php endif; ?>
	<strong class="mt-5 h3">Gestion de client</strong>
	<hr>
</div>
<div class="container mt-5">
	<div class="row">
		<div class="col-md-4">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalDefault">
            <i class="bi-plus-circle me-2"></i>Ajouter client
		 	</button>
		</div>
		 <div class="modal fade" id="exampleModalDefault" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header bg-primary text-light">
		        <h3 class="modal-title" id="exampleModalLabel">Ajouter client</h3>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      	<!-- ********************************************************************************************* -->
		      <div class="modal-body">

		      			<div>
										<form action="" method="POST">
												<div class="form-group mt-3">
													<label for="prix">Nom</label>
													<input type="text" name="nom" id="nom" class="form-control">
												</div>
												<div class="form-group mt-3">
													<label for="stock">numtel</label>
													<input type="text" name="numtel" id="numtel" class="form-control">
												</div>
												<div class="form-group">
													<button type="submit" class="btn btn-success mt-3"style="float:right;"name="valider">Enregistrer</button>
												</div>
										</form>
								</div>
		      </div>
		      <div class="modal-footer">
		      </div>
		    </div>
		  </div>
		</div>
		<div class="col-md-3"style="margin-left:360px;">
			<form  method="GET">
					<input type="search" name="rechercher" class="form-control ms-1" placeholder="rechercher">
					<input type="submit" name="recherche" value="rechercher" class="btn btn-success" style="margin-left: 265px;margin-top: -64px;">
			</form>
		</div>
	</div>

<!-- tableau -->

<div class="card border">
	<div class="card-header border-bottom">
		Nouvelle réservation
	</div>
	<div class="card-body">
			 <table class="table text-center table-bordered">
          <thead class="bg-primary text-light">
          <tr> 
            <th>ID</th>
            <th>NOM</th>
            <th>Numéro téléphone</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          	<?php foreach ($articles as $article){ ?>
          			<tr>
            
			            <td><?=$article['idcli'] ?></td>
			            <td><?=$article['nom'] ?></td>
			            <td><?=$article['numtel'] ?></td>
			            <td class="text-light">
            			<a href="modifier_client.php?id=<?=$article['idcli'] ?>" class="bi-pen bg-primary text-light p-2 ps-2 pe-2 rouded"></a>
									<a href="delete_client.php?id=<?=$article['idcli'] ?>"class="bi-trash-fill bg-danger text-light p-2  ps-2 pe-2 rouded"></a>
            			</td>
          			</tr>
       		<?php } ?>
         </tbody>
       </table>
     
	</div>
</div>
 </div>






















<?php require "footer.php"; ?>