<?php
    require_once 'includes/bootstrap.php';
    if (isset($_GET['id']) && isset($_GET['token'])){
        $auth = App::getAuth();
        $db = App::getDatabase();
        $user = $auth->getUserFromToken($db, $_GET['id'], $_GET['token']);
        if ($user){       
            if (!empty($_POST)){
                $validator = new Validator($_POST);
                $validator->isConfirmed('password');
                if ($validator->isValid()){
                    $password = $auth->hashPassword($_POST['password']);
                    $db->query('UPDATE '.$db_config['db_name'].'.'.$db_config['user_table'].' SET password = ?, reset_token = NULL reset_Date = NULL WHERE id = ?', [$password, $_GET['id']]);
                    $auth->connect('$user');
                    Session::getInstance()->setFlash('success', "Mot de passe modifié avec succès.");     
                    App::redirect('account.php');
                }
            }
        }else{
            Session::getInstance()->setFlash('danger', "ce token n'est pas valide.");
            App::redirect('login.php');
        }
    }
    else{
        App::redirect('login.php');
    }
?>

<?php require 'includes/header.php';?>
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