<?php
require_once 'includes/bootstrap.php';
App::getAuth()->restrict();
$db = App::getDatabase();
$user = Session::getInstance()->read('auth');
require '/app/config/info_db.php';
$db->query("DELETE FROM " .$db_config['db_name'].".".$db_config['user_table']. " WHERE id = ?", [$user->id]);
Session::getInstance()->setFlash('success', "Votre compte et vos informations ont bien été supprimés.");
App::getAuth()->logout();
App::redirect("login.php");
?>