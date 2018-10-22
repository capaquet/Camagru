<?php
    require_once 'includes/bootstrap.php';
    if(!empty($_POST) && !empty($_POST['email'])){
        $db = App::getDatabase();
        $auth = App::getAuth();
        if($auth->resetPassword($db, $_POST['email'])){
            Session::getInstance()->setFlash('success', "Instructions de réinitialisation du mot de passe envoyé par email.");
            App::redirect('login.php');
        }else{
            Session::getInstance()->setFlash('danger', "Aucun compte ne correspond à cette adresse.");
        }
    }
?>

<?php require 'includes/header.php';?>
<h1>Récupération de votre mot de passe</h1>
<form action="" method="POST">
    <div class="form-group">
        <label for="">Veuillez saisir votre adresse email</label>
        <input type="email" name="email" class="form-control"/>
    </div>
    <div>
        <button type="submit" class="btn btn-summary"> Soumettre</button>
    </div>
</form>

<?php require 'includes/footer.php';?>