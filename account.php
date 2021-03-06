<?php
    require_once 'includes/bootstrap.php';
    App::getAuth()->restrict();

    if (!empty($_POST)){
        if (isempty($_POST['password']) || $POST['password'] != $_POST['password_confirmation']){
            $_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas.";
        }
        else{
            $user_id = $_SESSION['auth']->id;
            $pwd = password_hash($_POST['password'], PASSWORD_BCRYPT);
            require_once"includes/db.php";
            $pdo->prepare("UPDATE ".$db_config['db_name'].".".$db_config['user_table']." SET password = ? WHERE id = ?")->execute([$pwd, $user_id]);
            $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour.";
            
        }
    }
?>
<?php require 'includes/header.php'; ?>

<h1>Bonjour <?= $_SESSION['auth']->username; ?></h1>

<form action="" method="post">
<div class ="form-group">
    <input class="form-control" type="password" name="password" placeholder="Modifier votre mot de passe">
</div>
<div class ="form-group">
    <input class="form-control" type="password" name="password_confirmation" placeholder="confirmer votre mot de passe">
</div>
<button class="btn btn-primary">Changer mon mot de passe</button>
</form>
<?php require 'includes/footer.php';?>


<!-- supprimer mon compte -->
<!-- modifier email, pseudo, mot de passe -->