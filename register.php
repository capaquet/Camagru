<?php
require_once "includes/db.php";
require_once "includes/tools.php";
    
    session_start();
    if (!empty($_POST)){
        $errors = array();
        if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])){
            $errors['username'] = "Pseudo invalide";
        }
        else{
            $req = $pdo->prepare("SELECT login from " . $db_config['db_name'] . "." .$db_config['user_table'] . " WHERE login = ?");
            $req->execute([ $_POST['username'] ]);
            $user = $req->fetch();
            if ($user){
                $errors['username'] = "Pseudo deja utilisé";}
        }
        if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Email invalide";}
        else{
            $req = $pdo->prepare("SELECT email from " . $db_config['db_name'] . "." .$db_config['user_table'] . " WHERE email = ?");
            $req->execute([ $_POST['email'] ]);
            $email = $req->fetch();
            if ($email){
                $errors['email'] = "Email deja utilisée";}
        }
        if(empty($_POST['password']) || ($_POST['password'] != $_POST['confirm']) || strlen($_POST['password']) < 8 || strlen($_POST['password']) >= 50){
            $errors['password'] = "Pwd invalide";
        }
        if (empty($errors)){
            $req = $pdo->prepare("INSERT INTO " . $db_config['db_name'] . "." .$db_config['user_table'] . " SET login = ?, password = ?, email = ?, confirmation_token = ?");
            $pwd = password_hash($_POST['password'], PASSWORD_BCRYPT);
            echo ('<br>');
            $token = random_str(60);
            $req->execute([ $_POST['username'], $pwd, $_POST['email'], $token ]);
            $user_id = $pdo->lastInsertID();
            var_dump($_POST);
            mail($_POST['email'], "Confirmation du compte", "merci de cliquer coco !\n\nlocalhost/confirm.php?id=$user_id&token=$token");
            $_SESSION['flash']['success'] = "Un email de confirmation vous a été envoyé pour validation du compte";
            header('location: login.php');
        }
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
    <title>Accueil</title>
  </head>

<h1>INSCRIPTION</h1>
<?php if (!empty($errors)): ?>
    <div class = "alert alert-danger">
    <p>Vous n'avez pas rempli le formulaire corretement.</p>
    <ul>
        <?php foreach($errors as $error): ?>
            <li> <?= $error; ?> </li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="" method="POST">
    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" class="form-control"/>
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control"/>
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input type="password" name="password" class="form-control"/>
    </div>
    <div class="form-group">
        <label for="">Password confirmatiom</label>
        <input type="password" name="confirm" class="form-control"/>
    </div>
    <div>
        <button type="submit" class="btn btn-summary"> Soumettre</button>
    </div>
</form>

<?php require 'includes/footer.php';?>