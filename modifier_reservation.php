<?php
session_start();
require "db.php";
require "security.php";
if (!empty($_GET['idreserv'])) {

	$idreserv=$_GET['idreserv'];

	 $sql=$connection->prepare("SELECT * FROM reserver WHERE idreserv=?");
	 $sql->execute(array($idreserv));

	 if ($sql->rowCount()==0) {
	 	$erreur=true;
	 }else
	 {
	 	$success=true;
	 	$reserver=$sql->fetch();
	 	if (isset($_POST['valider'])) {
	 		if (!empty($_POST['idreserv']) AND !empty($_POST['date_reserv']) AND !empty($_POST['date_voyage']) AND !empty($_POST['payement']) AND !empty($_POST['idvoit']) AND !empty($_POST['idcli']) AND !empty($_POST['place'])){

				    $idreserv=htmlspecialchars($_POST['idreserv']);
			        $datereserv=htmlspecialchars($_POST['date_reserv']);
			        $datevoyage=htmlspecialchars($_POST['date_voyage']);
			        $payement=htmlspecialchars($_POST['payement']);
			        $montant=htmlspecialchars($_POST['montant_avance']);
			        $idvoit=htmlspecialchars($_POST['idvoit']);
			        $idcli=htmlspecialchars($_POST['idcli']);
			        $place=htmlspecialchars($_POST['place']);

            if($datereserv>$datevoyage)
            {
                $error="La date du voyage doit être supérieur à la date du réservation";
            }else
            {

                $sql=$connection->prepare("SELECT place as place FROM reserver WHERE idreserv=?");
                $sql->execute(array($_GET['idreserv']));
                $place_libre=$sql->fetch()['place'];

                $sql=$connection->prepare("SELECT idvoit as idvoit FROM reserver WHERE idreserv=?");
                $sql->execute(array($_GET['idreserv']));
                $idvoiture=$sql->fetch()['idvoit'];


                $occupation="non";
                $update=$connection->prepare("UPDATE place SET occupation=? WHERE idvoit=? AND place=?");
                $update->execute(array($occupation,$idvoiture,$place_libre));


                $sql='SELECT occupation as occupation from place WHERE idvoit=:i and place=:p';
                $occupation=$connection->prepare($sql);
                $occupation->bindValue(':p',$place,PDO::PARAM_INT);
                $occupation->bindValue(':i',$idvoit,PDO::PARAM_STR);
                $occupation->execute();
                $occuper=$occupation->fetch()['occupation'];

                if($occuper=="non")
                {

        	        $update=$connection->prepare("UPDATE reserver SET idreserv=?,date_reserv=?,date_voyage=?,payement=?,montant_avance=?,idvoit=?,idcli=?,place=? WHERE idreserv=?");
        	        $update->execute(array($idreserv,$datereserv,$datevoyage,$payement,$montant,$idvoit,$idcli,$place,$idreserv));

                    
                    $occupation="oui";
                    $update=$connection->prepare("UPDATE place SET occupation=? WHERE idvoit=? AND place=?");
                    $update->execute(array($occupation,$idvoit,$place));

                    header("location:reserver.php");
                }
                else
                {
                    $error="cette place est occuper";
                }
	 		}
	 	}
	 }
    }
}else
{
	$erreur=true;
}
?>
<?php 
    $sql=$connection->prepare("SELECT * FROM voiture");
    $sql->execute();
    $voitures=$sql->fetchAll(PDO::FETCH_OBJ);
?>
<?php 
	$sql=$connection->prepare("SELECT * FROM client");
	$sql->execute();
	$clients=$sql->fetchAll(PDO::FETCH_OBJ);
?>
<?php require "header.php";?>

<?php if (isset($erreur)): ?>
    <?php $acceuil=true; ?>
	<div class="text-center mt-5">
		<img src="image/sad.png"height="100px;"><br><br>
		<strong class="text-danger">Oupsss!!!</strong>
		<p class="text-muted">Aucune réservation n'a été trouvée.</p><br>
		<a href="reserver.php"class="btn btn-outline-primary">Retourner</a>
	</div>
<?php endif ?>
<?php if (isset($success)): ?>
	<?php require "navbar.php"; ?>
	<div class="container mt-3">
        <?php if(isset($error)):?>
        <div class="alert alert-danger text-center alert-dismissible fade show"role="alert">
            <strong><?= $error ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <p class="mt-5"><strong class="h3">Gestion de réservation</strong></p>
    <hr>
    <p>Modifier les informations sur la réservation</p>
    <hr>
    <form method="POST">
        <div class="row">
            <div class="col-md-6">
                <label>ID réservation</label>
                <input type="text" name="idreserv"class="form-control"value="<?= $reserver['idreserv'] ?>">
            </div>
            <div class="col-md-6">
                <label>Montant avance</label>
                <input type="number" name="montant_avance"class="form-control"value="<?= $reserver['montant_avance'] ?>">
            </div>
        </div><br><br>
        <div class="row">
            <div class="col-md-6">
                <label>Date réservation</label>
                <input type="datetime-local" name="date_reserv"class="form-control"value="<?= $reserver['date_reserv'] ?>">
            </div>
            <div class="col-md-6">
                <label>ID voiture</label>
                <select name="idvoit"class="form-control">
                    <?php foreach($voitures as $voiture):?>
                        <option value="<?= $voiture->idvoit?>"><?= $voiture->idvoit?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div><br><br>
        <div class="row">
            <div class="col-md-6">
                <label>Date voyage</label>
                <input type="date" name="date_voyage"class="form-control"value="<?= $reserver['date_voyage'] ?>">
            </div>
            <div class="col-md-6">
                <label>ID client</label>
                <select name="idcli"class="form-control">
                    <?php foreach($clients as $client):?>
                        <option value="<?= $client->idcli?>"><?= $client->idcli?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div><br><br>
        <div class="row">
            <div class="col-md-6">
                <label>Payement</label>
                <select name="payement"class="form-control">
                    <option value="sans avance">Sans avance</option>
                    <option value="avec avance">Avec avance</option>
                    <option value="tout payé">Tous payé</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Place</label>
                <input type="number" name="place"class="form-control"value="<?= $reserver['place'] ?>">
            </div>
        </div>
        <button type="submit"class="btn btn-success mt-4 mb-3"name="valider"style="float:right;">Valider</button>
    </form>
</div>
<?php endif ?>
<?php require "footer.php"; ?>