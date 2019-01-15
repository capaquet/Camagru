<?php
    require_once 'includes/bootstrap.php';
    require '/app/config/info_db.php';
    App::getAuth()->restrict();

//recuperer l'image transmise dans la requete POST et la transforme en format png
    $img = $_POST['image'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
    $data = base64_decode($img);

//Enregistre la photo dans la db avec son proprietaire et nous retourne un id qui sera son nom
    $user_id = Session::getInstance()->read('auth')->id;
    $username = Session::getInstance()->read('auth')->username;
    $db = App::getDatabase();
    Image::save_image($db, $user_id);

//enregistre la photo en local avec l'id de celle-ci dans la db.
    $img_id = $db->lastInsertID();
    $success = file_put_contents("./images/".$img_id.'.png', $data);
    // header('Content-type: application/json');
    if ($success){
        $data = [];
        $data['status'] = 'success';
        $data['username'] = $username;
        $data['img_id'] = $img_id;
        print(json_encode($data));
    }
    else{
        $data = [];
        $data['status'] = 'failure';
        print(json_encode($data));
    }
    // print $success ? "Votre montage a ete sauvegarde !" : 'Une erreur est survenue pendant la sauvegarde de votre montage.';
  

    // header('Content-type: application/json');


    // echo ($username. "#" . $img_id);
    // print $success ? "Votre montage a ete sauvegarde !" : 'Une erreur est survenue pendant la sauvegarde de votre montage.';
// mettre le message d erreur dans le message flash