<?php
    require_once 'includes/bootstrap.php';
    App::getAuth()->restrict();
    App::getAuth()->logout();
    Session::Getinstance()->setFlash('success', "Vous êtes maintenant déconnecté.");
    App::redirect("login.php");
?>