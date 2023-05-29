<?php
session_start();
require "db.php";

if (isset($_POST['connecter'])) {
    if (!empty($_POST['email']) AND !empty($_POST['mdp'])) {
        $email=htmlspecialchars($_POST['email']);
        $mdp=htmlspecialchars($_POST['mdp']);

        $query=$connection->prepare("SELECT * FROM admin WHERE email=?");
        $query->execute(array($email));
        $admin=$query->fetch();
        if ($query->rowCount()>0) {
            if ($mdp==$admin['mdp']) {
                $_SESSION['login']=true;
                $_SESSION['admin']=$admin;
                header("location:acceuil.php");
            }else
            {
                $erreur="Votre mot de passe est incorrecte";
            }
        }else
        {
            $erreur="Votre email est incorrecte";
        }
    }else
    {
        $erreur="Tous les champs sont obligatoire";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion de réservation</title>
    <link rel="stylesheet" type="text/css" href="bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style.min.css">
    <script src="jquery.min.js "></script>
  <style>
    .etoile 
      {
          color:red;
      }
  </style>
</head>
<body style="background:white;">
<div class="main-wrapper">
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
        style="background:url(image/auth-bg.jpg) no-repeat center center;">
        <div class="auth-box row">
            <div class="col-lg-6 col-md-4 modal-bg-img" style="background-image: url(image/v5.jpg);">
            </div>
            <div class="col-lg-6 col-md-8 bg-white">
                <div class="p-3">
                    <div class="text-center">
                        <img src="image/favicon.png" alt="logo">
                    </div>
                    <h2 class="mt-3 text-center">Se connecter</h2>
                    <p class="text-center">Entrer votre email et mot de passe pour se connecter</p>
                        <?php   if (isset($erreur)):?>
                            <strong class="text-danger text-center ms-5">
                                <?php echo $erreur; ?>
                            </strong>
                        <?php endif; ?>
                    <form class="mt-4"method="POST">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label class="form-label text-dark" for="uname">Email <strong class="etoile">*</strong></label>
                                    <input class="form-control" id="uname" type="email"
                                        placeholder="Entrer votre email"name="email">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label class="form-label text-dark" for="pwd">Mot de passe <strong class="etoile">*</strong></label>
                                    <input class="form-control" id="pwd" type="password"
                                        placeholder="Entrer votre mot de passe"name="mdp">
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn w-100 btn-dark"name="connecter">se connecter</button>
                            </div>
                            <span class="text-muted mt-3 ms-500"><strong class="etoile">*</strong>:Champs obligatoire</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="bootstrap.min.js "></script>
</body>
</html>