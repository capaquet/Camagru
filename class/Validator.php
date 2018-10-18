<?php

class Validator{

    private $data;
    private $errors = [];
    
    public function __construct($data){
        $this->data = $data;    
    }

    private function getField($field){
        if (!isset($this->data[$field])){
            return null;
        }
        return $this->data[$field];
    }

// Vérification des charactères du pseudo
    public function isAlpha_num($field, $errorMsg){
        if(!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))){
            $this->errors[$field] = $errorMsg;
        }
    }

// Vérification de l'unicité d'élément dans la base de données (pseudo et email)
    public function isUniq($field, $db, $errorMsg){
        require '/app/config/info_db.php'; 
        $entry = $db->query("SELECT id FROM ".$db_config['db_name'].".".$db_config['user_table']." WHERE $field = ?",
            [$this->getField($field)])->fetch();
        if ($entry){
            $this->errors[$field] = $errorMsg;
         } 
    }

// Vérification des charactères de l'email
    public function isEmail($field, $errorMsg){
        if(empty($_POST['email']) || !filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)){
            $this->errors[$field] = $errorMs;
        } 
    }

// Vérification de la taille du mot de passe et de sa confirmation
    public function isConfirmed($field, $errorMsg){
        if(empty($this->getField($field)) || strlen($this->getField($field)) < 8 || strlen($this->getField($field)) >= 50
        || $this->getField($field) != $this->getField($field.'_confirm')){      
            $this->errors[$field] = $errorMsg;
        }
    }

// Vérification de la présence d'erreurs
    public function isValid(){
        return empty($this->errors);
    }

// Récupération de la liste des erreurs
    public function getErrors(){
        return $this->errors;
    }

} 