<?php require 'includes/header.php';?>
<?php require 'includes/tools.php';?>

<?php
    if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
        require 'includes/db.php';

        var_dump($_POST['username']);
        $req = $pdo->prepare("SELECT * FROM " .$db_config['db_name'].".".$db_config['user_table']. " WHERE (login = :username OR email = :username)");
        $req->execute(['username' => $_POST['username']]);
        $user = $req->fetch();
        if(password_verify($_POST['password'], $user->password)){
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = "Vous êtes maintenant connecté.";
            header('location: account.php');
            exit();
        }
        else{
            var_dump($_SESSION);
            $_SESSION['flash']['danger'] = "Email ou mot de passe incorrect";
            header('location: login.php');
        }
    
    }
?>

<h1>Se connecter</h1>
<form action="" method="POST">
    <div class="form-group">
        <label for="">Login ou Email</label>
        <input type="text" name="username" class="form-control"/>
    </div>

    <div class="form-group">
        <label for="">Password</label>
        <input type="password" name="password" class="form-control"/>
    </div>
    <div>
        <button type="submit" class="btn btn-summary"> Soumettre</button>
    </div>
</form>

<?php require 'includes/footer.php';?>