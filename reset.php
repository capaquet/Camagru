<?php require 'includes/header.php';?>
<?php require 'includes/tools.php';?>

<?php
    if (isset($_GET['id']) && isset($_GET['token'])){
        require "includes/db.php";
        $req = $pdo->prepare('SELECT * FROM '.$db_config['db_name'].'.'.$db_config['user_table'].' WHERE id = ? AND token = ? AND reset_date > DATE_SUB(NOW() INTERVAL 30 MINUTE)');
        $req->execute([$_GET['id'], $_GET['reset_token']]);
        $user = $req->fetch();
        if($user){
            if (!empty($_POST)){
                if (!empty($_POST['password']) && !empty($_POST['password']) && $_POST['password'] == $_POST['password_comnfirm']){
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $pdo->prepare('UPDATE '.$db_config['db_name'].'.'.$db_config['user_table'].' SET password = ?, reset_token = NULL reset_Date = NULL WHERE id = ?');
                    $pdo->execute([$password, 'id' => $user->id]);
                    session_start();
                    $_SESSION['flash']['success'] = "Mot de passe modifié";
                    header('location : account.php');
                    exit();
                }
            }
        }
    }
    else{
        session_start();
        $_SESSION['flash']['danger'] = "Ce token n'est pas valide.";
        header('location: login.php');
        exit();
    }

    if(!empty($_POST) && !empty($_POST['password']) && !empty($_POST['password_confirm'])){
        require 'includes/db.php';
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
            $_SESSION['flash']['danger'] = "Email ou mot de passe incorrect";
            header('location: login.php');
            exit();
        }
    }
?>

<h1>Se connecter</h1>
<form action="" method="POST">
    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control"/>
    </div>
    <div class="form-group">
        <label for="">Confirmation du mot de passe</label>
        <input type="password" name="password_confirmation" class="form-control"/>
    </div>
    <div>
        <button type="submit" class="btn btn-summary"> Soumettre</button>
    </div>
</form>

<?php require 'includes/footer.php';?>