<?php
    require "db.php";
    $sql=$connection->prepare("SELECT * FROM voiture");
    $sql->execute();
    $voitures=$sql->fetchAll(PDO::FETCH_OBJ);
 ?>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
  <a href="acceuil.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none ps-5">
    <img src="image/favicon.png">
    <span class="text-light ms-3 h3 mt-2">Gestion de réservation</span>
  </a>
  <ul class="nav col-md-auto mb-2 justify-content-center mb-md-0">
    <li><a href="acceuil.php" class="nav-link px-2 link-light">Acceuil</a></li>
    <li><a href="client.php" class="nav-link px-2 link-light">Client</a></li>
    <li><a href="reserver.php" class="nav-link px-2 link-light"id="menu-link">Réservation</a></li>
    <li><a href="voiture.php" class="nav-link px-2 link-light"id="menu-link">Voiture</a></li>
    <li><a href="place.php" class="nav-link px-2 link-light"id="menu-link">Place</a></li>
  </ul>
  <form role="search"method="GET"action="chercher.php"class="row">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-3 ms-2">
          <select name="cherchervoit"class="form-control bg-dark"style="color:white;width:200px;">
            <option value="">Séléctionner une voiture</option>
            <?php foreach($voitures as $voiture):?>
                <option style="color:white;"value="<?= $voiture->idvoit?>"><?= $voiture->idvoit?></option>
            <?php endforeach; ?>
          </select> 
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-3">
          <select name="chercher"class="form-control bg-dark ms-4"style="color:white;width:200px;">
            <option style="color:white;"value="sans avance">Sans avance</option>
            <option style="color:white;"value="avec avance">Avec avance</option>
            <option style="color:white;"value="tout payé">Tous payé</option>
          </select>
        </div> 
      </div>
    </div>
    <div class="col-md-2 ms-1">
        <button type="submit"class="btn btn-success"name="valider">Chercher</button>
        <!-- <a href="deconnecter.php"class="btn btn-outline-primary me-3"><i class="bi-box-arrow-in-right me-1"></i></a> -->
    </div>
    </form>
</header>
 