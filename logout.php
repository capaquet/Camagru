<?php
    require_once 'includes/bootstrap.php';
    App::getAuth()->logout();
    Session::Getinstance()->setFlash('success', "Vous êtes maintenant déconnecté.");
    App::redirect("login.php");
?>