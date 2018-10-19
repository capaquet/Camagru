<?php

    class App{

        static $db = null;

        static function getDatabase(){
            if (!self::$db){
                self::$db = new Database();
                
            }
            return self::$db;
        }
    
        static function getAuth(){
            return new Auth(Session::getInstance(),['restriction_msg' => 'Veuillez vous connecter pour accéder à cette page.']);
        }

        static function redirect($page){
            header("location: $page");
        }
    }