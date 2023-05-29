<?php 
session_start();
require "db.php";
require "security.php";
require "header.php";
require "navbar.php";

$sql=$connection->prepare("SELECT * FROM voiture");
$sql->execute();

 ?>
<div class="container mb-5">
    <?php if(isset($erreur)):?>
        <div class="alert alert-danger text-center alert-dismissible fade show"role="alert">
            <strong><?= $erreur ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <strong class="mt-5 h3">Gestion de place</strong>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <h4>Chercher une place libre</h4>
            <?php
                if (!empty($_GET['place_libre'])) {
                    $idvoit=$_GET['place_libre'];
                    $req=$connection->prepare("SELECT idvoit FROM  voiture WHERE idvoit=?");
                    $req->execute(array($idvoit));

                    if ($req->rowCount()==0) {
                        $voiture_introuvable="Cette voiture n'existe pas dans la base de données";
                    }else
                    {
                        $recherche=true;
                        $idvoit=$_GET['place_libre'];
                        $libre=$connection->prepare("SELECT distinct * FROM place WHERE idvoit=?");
                        $libre->execute(array($idvoit));
                    }
                }
             ?>
            <form method="GET">
                <label>Identifiant du voiture</label>
                <input type="search" name="place_libre"class="form-control"placeholder="Entrer l'indentifiant du voiture"value="<?= htmlspecialchars($_GET['place_libre'] ?? null) ?>">
            </form>
            <?php if(isset($voiture_introuvable)):?>
                <div class="alert alert-danger text-center alert-dismissible fade mt-2 show"role="alert">
                    <strong><?= $voiture_introuvable ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(isset($recherche)):?>
                <div class="card  border mt-3"style="box-shadow:none;">
                  <div class="card-header border-bottom bg-primary">
                    <h5 class="card-title text-center text-light">Place libre du voiture</h5>
                  </div>
                  <ul class="list-group list-group-flush">
                    <?php while($place=$libre->fetch()):?>
                        <li class="list-group-item text-center list-group-item-action"style="cursor:pointer;">place N°<strong><?= $place['place'];?>
                            <h4 style="float:right;"><span class="badge <?php if ($place['occupation']=="oui") {
                                echo "bg-success";
                            }else
                            {
                                echo "bg-danger";
                            }?> rounded-pill pb-2"><?php echo $place['occupation']; ?></span></h4>
                        </strong></li>
                    <?php endwhile; ?>
                  </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
 <?php require "footer.php"; ?>