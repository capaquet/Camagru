<?php

function debug($var){
    echo '<pre>' . print_r($var, true) . '</pre>';
}

function random_str($length){
    $alphabet = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function control_auth(){
    if (session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['auth'])){
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('location: login.php');
        exit();
    }
}