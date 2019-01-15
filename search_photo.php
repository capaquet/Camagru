<?php
    require_once 'includes/bootstrap.php';
    require '/app/config/info_db.php';
    App::getAuth()->restrict();
    
    $user_id = Session::getInstance()->read('auth')->id;
    $username = Session::getInstance()->read('auth')->username;
    $db = App::getDatabase();
    $photo_list = Image::search_image($db, $user_id);
    if (count($photo_list) > 0){
        for ($i = 0; $i < count($photo_list); $i++){
            echo("#" . $photo_list[$i]->img_id);
        }
    }