<?php require 'includes/header.php';?>
<?php require 'includes/tools.php';?>
<?php
    if(!empty($_POST) && !empty($_POST['email'])){
        require 'includes/db.php';
        $req = $pdo->prepare("SELECT * FROM ".$db_config['db_name'].".".$db_config['user_table']." WHERE email = ? AND confirmation_date IS NOT NULL");
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        var_dump($user);
        if($user){ 
            session_start();
            $reset_token = random_str(60);
            $pdo->prepare("UPDATE ".$db_config['db_name'].".".$db_config['user_table']." SET reset_token = ?, reset_date = NOW() WHERE id = ?")->execute([$reset_token, $user->id]);
            $_SESSION['flash']['success'] = "Instructions de réinitialisation du mot de passe envoyé par email.";
            mail($_POST['email'], "Réinitialisation du mot de passe", "merci de cliquer coco !\n\nlocalhost/reset.php?id={$user->id}&token=$reset_token");
            header('location: login.php');
            echo "yyyoooooolooooo";
            exit();
        }
        else{
            echo "yyyooooooloooooddddddddd";
            $_SESSION['flash']['danger'] = "Aucun compte ne correspond à cette adresse.";
        }
    }
?>

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