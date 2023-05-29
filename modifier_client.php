<?php 
session_start();
require "header.php";
require_once('navbar.php');
require_once('security.php'); 
 ?>
<?php 
	require_once('db.php');
	if($_GET['id'] && !empty($_GET['id']))
	{
		
		$id=strip_tags($_GET['id']);
		$sql='SELECT * FROM client where idcli= :id';
		$data = $connection->prepare($sql);
		$data->bindValue(':id',$id,PDO::PARAM_INT);
		$data->execute();
		$article=$data->fetch();
		if($article)
		{	
			
			if(!empty($_POST['nom']) && !empty($_POST['numtel']))	
			{
				$nom=strip_tags($_POST['nom']);
				$numtel=strip_tags($_POST['numtel']);
				$sql='UPDATE client SET nom=:nom,numtel=:numtel where idcli=:id';
				$data=$connection->prepare($sql);
				$data->bindValue(':id',$id,PDO::PARAM_INT);
				$data->bindValue(':nom',$nom,PDO::PARAM_STR);
				$data->bindValue(':numtel',$numtel,PDO::PARAM_STR);
				$data->execute();
				header('Location: client.php');
			}
		}
		elseif (!$article) {
			header('Location: attention.php');
		}
		
		
		
	}
	else
	{
		header('Location:attention.php');
		
	}

 ?>
<main class="container">
	<div class="col-md-12 mt-5">
		<div class="card border">
			<div class="card-header border-bottom">
			<h4 class="text-muted">Modification du client</h4>
		</div>
		<div class="card-body">
			<div class="col-md-6 " style="margin-left:250px;">
				<form action="" method="POST">
						<div class="form-group">
							<label for="prix">Nom</label>
							<input type="text" name="nom" id="nom" value="<?=$article['nom'] ?>" class="form-control">
						</div>
						<div class="form-group mt-3">
							<label for="stock">numtel</label>
							<input type="text" name="numtel" id="numtel" value="<?=$article['numtel'] ?>" class="form-control">
						</div>
						<div class="form-group pb-5">
							<button type="submit" class="btn btn-primary mt-4" style="width:530px;">Valider</button>
						</div>
				</form>
			</div>
		</div>
	</div>
</div>		
</main>
<?php require "footer.php"; ?>