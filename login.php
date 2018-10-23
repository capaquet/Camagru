<?php
    require_once 'includes/bootstrap.php';

    $auth = App::getAuth();
    $db = App::getDatabase();
    $auth->connect_from_cookie($db);
//Si l'utilisateur est déjà connecté, redirection vers account.php
    if ($auth->user()){
        App::redirect('account.php');
    }

    if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
        $user = $auth->login($db, $_POST['username'], $_POST['password'], isset($_POST['remember']));
        $session = Session::getInstance();
        if ($user){
            $session->setFlash('success', "Vous êtes maintenant connecté.");
            App::redirect('account.php');
        }
        else{
            $session->setFlash('danger', "Email ou mot de passe incorrect");
        }
    }
?>


<?php require 'includes/header.php';?>
<h1>Se connecter</h1>
<form action="" method="POST">
    <div class="form-group">
        <label for="">Login ou Email</label>
        <input type="text" name="username" class="form-control"/>
    </div>

    <div class="form-group">
        <label for="">Password</label>
        <input type="password" name="password" class="form-control"/>
        <a href="forget.php">Mot de pass oublié</a>
    </div>
    <div class="form-group">
    <label><input type="checkbox" name="remember" value="1">Se souvenir de moi</label>
    </div>
    <div>
        <button type="submit" class="btn btn-summary"> Soumettre</button>
    </div>
</form>

<?php require 'includes/footer.php';?>