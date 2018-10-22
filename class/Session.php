<?php

class Session{

    static $instance;

// Methode "singleton" - permet de n'ouvrir qu'une seule session
    static function getInstance(){
        if (!self::$instance)
            self::$instance = new Session();
        return self::$instance;
    }

    public function __construct(){
        session_start();
    }

    public function setFlash($key, $msg){
        $_SESSION['flash'][$key] = $msg;
    }

    public function hasFlash(){
        return isset($_SESSION['flash']);
    }

    public function getFlash(){
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    
    public function write($key, $info){
        $_SESSION[$key] = $info;
    }

    public function read($key){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null ;
    }

    public function delete($key){
        unset($_SESSION[$key]);
    }
}