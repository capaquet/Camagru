<?php

class Str{
    
    static function random($length){
        $alphabet = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }
}