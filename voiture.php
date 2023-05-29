<?php 
session_start();
require "db.php";
require "security.php";
require "header.php";
require "navbar.php";

if (isset($_POST['enregistrer'])) {
    if (!empty($_POST['idvoit']) AND !empty($_POST['design']) AND !empty($_POST['type']) AND !empty($_POST['nbrplace']) AND !empty($_POST['frais'])) {
           
        $idvoit=htmlspecialchars($_POST['idvoit']);
        $design=htmlspecialchars($_POST['design']);
        $type=htmlspecialchars($_POST['type']);
        $nbrplace=htmlspecialchars($_POST['nbrplace']);
        $frais=htmlspecialchars($_POST['frais']);
        $query=$connection->prepare("INSERT INTO voiture VALUES(?,?,?,?,?)");
        $query->execute(array($idvoit,$design,$type,$nbrplace,$frais));

        for ($i=1; $i <= $nbrplace; $i++) { 
            $occupation="non";
            $sql=$connection->prepare("INSERT INTO place VALUES(?,?,?)");
            $sql->execute(array($i,$occupation,$idvoit));
        }
    }else   
    {
        $erreur="Veuillez complétez tous les champs";
    }
}
 ?>
<div class="container mt-3">
    <?php if(isset($erreur)):?>
        <div class="alert alert-danger text-center alert-dismissible fade show"role="alert">
            <strong><?= $erreur ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <p class="mt-5"><strong class="h3">Gestion de voiture</strong></p>
    <hr>
    <p>Ajouter les informations sur la voiture</p>
    <hr>
    <form method="POST"class="mb-5"> 
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Identifiant</label>
                    <input type="text" name="idvoit"class="form-control">
                </div>
                 <div class="form-group mt-2">
                    <label>Design</label>
                    <input type="text" name="design"class="form-control">
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
                <input type="text" name="nbrplace"class="form-control">
            </div>
            <div class="form-group mt-2">
                <label>Frais</label>
                <input type="text" name="frais"class="form-control">
            </div>
            <div class="form-group mt-4 mb-1"style="float:right;">
                <button class="btn btn-success"name="enregistrer">
                <i class="bi-save me-2"></i>
                    Enregistrer</button>
            </div>
        </div>
    </form>
    <table class="table  text-center table-bordered mt-3">
        <thead class="bg-primary text-light">
            <tr>
                <th><strong>Identifiant voiture</strong></th>
                <th>Designation</th>
                <th>Type</th>
                <th>Nombre de place</th>
                <th>Frais</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php 
            $sql=$connection->prepare("SELECT * FROM voiture");
            $sql->execute();
         ?>
        <tbody>
            <?php while ($voiture=$sql->fetch()):?>

                    <tr>
                        <td><?= $voiture['idvoit'] ?></td>
                        <td><?= $voiture['design'] ?></td>
                        <td><?= $voiture['type'] ?></td>
                        <td><?= $voiture['nbrplace'] ?></td>
                        <td> <strong><?= $voiture['frais'] ?> Ar</strong></td>
                        <td>
                            <a href="modifier_voiture.php?idvoit=<?= $voiture['idvoit'] ?>"class="bi-pen bg-primary text-white p-2 ps-2 pe-2 rounded"></a>
                            <a href="delete_voiture.php?idvoit=<?= $voiture['idvoit'] ?>"class="bi-pen bg-danger text-white p-2 ps-2 pe-2 rounded bi-trash-fill"></a>
                        </td>
                    </tr>

            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php require "footer.php"; ?>