<?require_once 'includes/header.php';?>

<?php
#require_once 'config/database.php';
require_once "includes/db.php";
require_once "includes/tools.php";

    if (!empty($_POST)){
        $errors = array();
        if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) || strlen($_POST['password']) <= 8 || strlen($_POST['password']) >= 50){
            $errors['username'] = "Pseudo invalide";
        }
        if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Email invalide";
        }
        if(empty($_POST['password']) || ($_POST['password'] != $_POST['confirm'])){
            $errors['password'] = "Pwd invalide";
        }
        if (empty($errors)){
            $req = $pdo->prepare("INSERT INTO " . $db_config['db_name'] . "." .$db_config['user_table'] . " SET login = ?, password = ?, email = ?");
            $pwd = password_hash($_POST['password'], PASSWORD_BCRYPT);
            echo ('<br>');
            echo(strlen($pwd));
            $req->execute([ $_POST['username'], $pwd, $_POST['email'] ]);
            die("Compte cree !");
        }
        else{
            debug($errors);
        }
    }

?>

<h1>INSCRIPTION</h1>

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