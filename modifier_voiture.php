<?php
session_start();
require "db.php";
require "security.php";
$acceuil=true;
if (!empty($_GET['idvoit'])) {
	$idvoit=$_GET['idvoit'];

	 $sql=$connection->prepare("SELECT * FROM voiture WHERE idvoit=?");
	 $sql->execute(array($idvoit));

	 if ($sql->rowCount()==0) {
	 	$erreur=true;
	 }else
	 {
	 	$success=true;
	 	$voiture=$sql->fetch();
	 	if (isset($_POST['valider'])) {
	 		if (!empty($_POST['idvoit']) AND !empty($_POST['design']) AND !empty($_POST['type']) AND !empty($_POST['nbrplace']) AND !empty($_POST['frais'])){
			$id=htmlspecialchars($_POST['idvoit']);
	        $design=htmlspecialchars($_POST['design']);
	        $type=htmlspecialchars($_POST['type']);
	        $nbrplace=htmlspecialchars($_POST['nbrplace']);
	        $frais=htmlspecialchars($_POST['frais']);

	        $update=$connection->prepare("UPDATE voiture set idvoit=?,design=?,type=?,nbrplace=?,frais=? WHERE idvoit=?");
	        $update->execute(array($id,$design,$type,$nbrplace,$frais,$idvoit));

	        
	        header("location:voiture.php");
	 		}
	 	}
	 }
}else
{
	$erreur=true;
}
 ?>
<?php require "header.php";?>

<?php if (isset($erreur)): ?>
	<div class="text-center mt-5">
		<img src="image/sad.png"height="100px;"><br><br>
		<strong class="text-danger">Oupsss!!!</strong>
		<p class="text-muted">Aucune voiture n'a été trouvée.</p><br>
		<a href="voiture.php"class="btn btn-outline-primary">Retourner</a>
	</div>
<?php endif; ?>
<?php if (isset($success)): ?>
	<?php require "navbar.php"; ?>
	<div class="container mt-3">
    <p class="mt-5"><strong class="h3">Gestion de voiture</strong></p>
    <hr>
    <p>Modifier les informations sur la voiture</p>
    <hr>
    <form method="POST">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" name="idvoit"class="form-control"value="<?= $voiture['idvoit']?>">
                </div>
                 <div class="form-group mt-2">
                    <label>Design</label>
                    <input type="text" name="design"class="form-control"value="<?= $voiture['design']?>">
                </div>
                <div class="form-group mt-2">
                    <label>Type</label>
                    <select name="type"class="form-control">
                        <option value="simple">Simple</option>
                        <option value="premium">Premium</option>
                        <option value="vip">VIP</option>
                    </select>
                </div>
        </div>
        <div class="col-md-5 ms-5">
            <div class="form-group mt-2">
                <label>Nombre de place</label>
                <input type="text" name="nbrplace"class="form-control"value="<?= $voiture['nbrplace'] ?>">
            </div>
            <div class="form-group mt-2">
                <label>Frais</label>
                <input type="text" name="frais"class="form-control"value="<?= $voiture['frais']?>">
            </div>
            <div class="form-group mt-4 mb-1"style="float:right;">
                <button class="btn btn-success"name="valider">Valider</button>
            </div>
        </div>
    </form>
</div>
<?php endif; ?>
<?php require "footer.php"; ?>