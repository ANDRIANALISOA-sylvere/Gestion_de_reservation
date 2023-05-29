<?php 
session_start();
$acceuil=true;
require "security.php";
require "header.php";
require "navbar.php";
require "db.php";
 ?>
<?php 
$query=$connection->prepare("SELECT count(idvoit) as count from voiture");
$query->execute();
$voiture=$query->fetch()['count'];
?>
<?php 
$query=$connection->prepare("SELECT count(idreserv) as count from reserver");
$query->execute();
$reserver=$query->fetch()['count'];
?>
<?php 
$query=$connection->prepare("SELECT count(idcli) as count from client");
$query->execute();
$client=$query->fetch()['count'];
?>
<?php 
$req=$connection->prepare("SELECT SUM(frais) as frais from voiture,reserver WHERE reserver.idvoit=voiture.idvoit");
$req->execute();
$recette=$req->fetch()['frais'];
 ?>
<div class="container">
    <strong class="mt-5 h3">Système de gestion de réservation</strong>
    <hr>
    <div class="row mt-5">
        <div class="col-sm-6 col-lg-3">
            <div class="card border-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium text-center"><?php echo $client ?></h2>
                            <h6 class="text-xs mb-0 w-100 text-primary"style="font-weight:bold;">Total clients
                            </h6>
                        </div>
                        <div class="mt-md-3 mt-lg-0 ms-5">
                            <span class="opacity-7 text-muted display-5"><i class="fas fa-user-circle"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-end ">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium text-center"><?php
                            if ($recette===null) {
                                echo "0";
                            }
                                echo $recette;
                             ?>
                            <span class="text-muted">Ar</span></h2>
                            <h6 class="text-success mb-0 w-100 text-truncate text-xs "style="font-weight:bold;">
                                Recette total accumulé
                            </h6>
                        </div>
                        <div class="mt-md-3 mt-lg-0 ms-3">
                            <span class="opacity-7 text-muted display-5"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-end ">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium text-center"><?php echo $reserver ?></h2>
                                <!-- <span
                                    class="badge bg-danger font-12 text-white font-weight-medium rounded-pill ms-2 d-md-none d-lg-block">-18.33%</span> -->
                            <h6 class="mb-0 w-100 text-truncate text-xs text-danger"style="font-weight:bold;">Total réservation
                            </h6>
                        </div>
                        <div class="mt-md-3 mt-lg-0 ms-5">
                            <span class="opacity-7 text-muted display-5"><i class="fas fa-chair"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium text-center"><?php echo $voiture ?></h2>
                            <h6 class="mb-0 w-100 text-truncate text-xs text-warning"style="font-weight:bold;">Total voiture</h6>
                        </div>
                        <div class="ms-5 mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted display-5"><i class="fas fa-car-side"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>









<?php require "footer.php"; ?>