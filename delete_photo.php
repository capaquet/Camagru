<?php
    require_once 'includes/bootstrap.php';
    require '/app/config/info_db.php';
    App::getAuth()->restrict();
    $db = App::getDatabase();
    Image::delete_image($db, $_POST['img_id']);
    unlink("./images/".$_POST['img_id'].'.png');
        // print $success ? "Votre montage a ete supprimme !" : 'Une erreur est survenue pendant la suppression de votre montage.';