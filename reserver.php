<?php 
session_start();
require "db.php";
require "security.php";
require "header.php"; 
require "navbar.php";
if (isset($_POST['valider'])) {
    if (!empty($_POST['idreserv']) AND !empty($_POST['date_reserv']) AND !empty($_POST['date_voyage']) AND !empty($_POST['idcli']) AND !empty($_POST['payement']) AND !empty($_POST['place'])  AND !empty($_POST['idvoit'])) {
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
            $erreur="La date du voyage doit être supérieur à la date du réservation";
        }else
        {
            $sql='SELECT occupation as occupation from place WHERE idvoit=:i and place=:p';
            $occupation=$connection->prepare($sql);
            $occupation->bindValue(':p',$place,PDO::PARAM_INT);
            $occupation->bindValue(':i',$idvoit,PDO::PARAM_STR);
            $occupation->execute();
            $occuper=$occupation->fetch()['occupation'];

            if($occuper=="non")
            {
                $query=$connection->prepare("INSERT INTO reserver VALUES(?,?,?,?,?,?,?,?)");
                $query->execute(array($idreserv,$idvoit,$idcli,$place,$datereserv,$datevoyage,$payement,$montant));

                $occupation="oui";
                $update=$connection->prepare("UPDATE place SET occupation=? WHERE idvoit=? AND place=?");
                $update->execute(array($occupation,$idvoit,$place));

            }
            else
            {
                $erreur="cette place est occuper";
            }
            
        }
    }else   
    {
        $erreur="Veuillez complétez tous les champs";
    }
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
<div class="container">
    <?php if(isset($erreur)):?>
        <div class="alert alert-danger text-center alert-dismissible fade show"role="alert">
            <strong><?= $erreur ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <strong class="mt-5 h3">Gestion de réservation</strong>
    <hr>
    <div class="card border">
        <div class="card-header border-bottom">
            Nouvelle réservation
        </div>
        <div class="card-body">
            <button class="btn btn-success"style="float:right;"data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi-plus-circle me-2"></i>Nouvelle réservation</button>
            <!-- modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header bg-primary text-light">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter une nouvelle réservation</h1>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>ID réservation</label>
                                    <input type="text" name="idreserv"class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Montant avance</label>
                                    <input type="number" name="montant_avance"class="form-control">
                                </div>
                            </div><br><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Date réservation</label>
                                    <input type="datetime-local" name="date_reserv"class="form-control">
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
                                    <input type="date" name="date_voyage"class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>client</label>
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
                                    <input type="number" name="place"class="form-control">
                                </div>
                            </div>
                            <button type="submit"class="btn btn-success mt-4"name="valider"style="float:right;">Valider</button>
                        </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- modal -->
            <table class="table mt-5 table-bordered text-center">
                <thead class="bg-primary text-light">
                    <tr>
                        <th>ID</th>
                        <th>Date réservation</th>
                        <th>Date voyage</th>
                        <th>Payement</th>
                        <th>Montant avance</th>
                        <th>ID voiture</th>
                        <th>ID du client</th>
                        <th>Place</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php 
                $sql=$connection->prepare("SELECT * FROM reserver");
                $sql->execute();
                ?>
                <tbody>
                    <?php while ($reserver=$sql->fetch()):?>

                        <tr>
                            <td><?= $reserver['idreserv'] ?></td>
                            <td><?= $reserver['date_reserv'] ?></td>
                            <td><?= $reserver['date_voyage'] ?></td>
                            <td><?= $reserver['payement'] ?></td>
                            <td><?= $reserver['montant_avance'] ?></td>
                            <td><?= $reserver['idvoit'] ?></td>
                            <td><?= $reserver['idcli'] ?></td>
                            <td><?= $reserver['place'] ?></td>
                            <td>
                                <a href="modifier_reservation.php?idreserv=<?= $reserver['idreserv'] ?>"class="bi-pen bg-primary text-white p-2 ps-2 pe-2 rounded"></a>
                                <a href="reçu.php?idreserv=<?= $reserver['idreserv'] ?>"class="bi-file-pdf bg-success text-white p-2 ps-2 pe-2 rounded"target="_blank"></a>
                                <a href="delete_reservation.php?idreserv=<?= $reserver['idreserv']  ?>"class="bi-trash-fill bg-danger text-white p-2 ps-2 pe-2 rounded"></a>
                            </td>
                        </tr>

                    <?php endwhile; ?>
            
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require "footer.php"; ?>