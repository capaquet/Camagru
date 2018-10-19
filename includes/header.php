<?php require_once "includes/bootstrap.php"; ?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <title>TEST GRAFIKART</title>
  </head>

<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="" aria-labelledby="dropdown01">
              <ul class ="navbar-nav">
              <?php if (isset($_SESSION['auth'])): ?>
                <li> <a href="logout.php">Se Déconnecter</a></li>
              <?php else: ?>
                <li><a class="" href="register.php">S'inscrire</a></li>
                <li><a class="" href="login.php">Se connecter</a></li>
              <?php endif;?>
              </ul>
            </div>
</nav>
<div class="container">
  <?php if(Session::getInstance()->hasFlash()): ?>
    <?php foreach(Session::getInstance()->getFlash() as $type => $message): ?>
      <div class ="alert alert-<?= $type; ?>">
        <?= $message; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
</body> 
<!doctype html>