<?php
    require_once 'includes/bootstrap.php';
    require '/app/config/info_db.php';
    App::getAuth()->restrict();

    $user_id = Session::getInstance()->read('auth')->id;
    $db = App::getDatabase();
    $photo_list = Image::delete_image($db, $user_id, $img_);
    }