<?php
    require 'includes/bootstrap.php';

//Connexion a la DB, vérification de la connexion utilisateur
    $db = App::getDatabase();
    $auth = App::getAuth();
    $auth->connect_from_cookie($db);

//Si l'utilisateur est déjà connecté, redirection vers account.php
    if ($auth->user()){
        Session::getInstance()->setFlash('success', "Vous êtes déjà connecté.");
        App::redirect('account.php');
    }

    if (!empty($_POST)){
        $errors = array();
        $db = App::getDatabase();
//Vérication des informations utilisateurs
        $validator = new Validator($_POST);
        $validator->isAlpha_num('username', "Ce pseudo n'est pas valide.");
        if ($validator->isValid()){
            $validator->isUniq('username', $db, "Ce pseudonyme est déjà utilisé pour un autre compte..");
            }
        $validator->isEmail('email', "Cet adresse email n'est pas valide.");
        if ($validator->isValid()){    
            $validator->isUniq('email', $db, "Cet adresse email  est déjà utilisée pour un autre compte.");
            }
        $validator->isConfirmed('password', "Les mots de passe ne correspondent pas.");
// Si aucune erreur n'a été détectée, création du compte utilisateur, sinon affichage des erreurs.
        if ($validator->isValid()){
            
            $info = App::getAuth()->register($db, $_POST['username'], $_POST['password'], $_POST['email']);
            Session::getInstance()->setFlash('success', "Un email de confirmation vous a été envoyé pour validation du compte");
            App::redirect("login.php");
        }
        else{
            $errors = $validator->getErrors();
        }
} 
//Ajouter les notifications
?>


<?php require 'includes/header.php';?>


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
        <input type="password" name="password_confirm" class="form-control"/>
    </div>
    <div>
        <button type="submit" class="btn btn-summary"> Soumettre</button>
    </div>
</form>

<?php require 'includes/footer.php';?>