<?php

$user_id = $_GET['id'];
$token = $_GET['token'];
require 'includes/db.php';
$req = $pdo->prepare("SELECT * FROM " . $db_config['db_name'] . "." .$db_config['user_table'] . " WHERE id = ?");
$req->execute([$user_id]);
$user = $req->fetch();
session_start();

if ($user && $user->confirmation_token == $token){
    session_start();
    $pdo->prepare("UPDATE " . $db_config['db_name'] . "." .$db_config['user_table'] . " SET confirmation_token = NULL, confirmation_date = NOW() WHERE id = ?")->execute([$user_id]);
    $_SESSION['auth'] = $user;
    $_SESSION['flash']['success'] = "Inscription confirmée. Vous êtes connecté";
    header('location: account.php');
} else{
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('Location: login.php');
}