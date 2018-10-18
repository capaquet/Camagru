<?php

class Database{

private $pdo;

    public function __construct(){
        require '/app/config/info_db.php'; 
        $this->pdo = new PDO($db_config['init'], $db_config['user'], $db_config['pwd']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    public function query($query, $params = false){
        if ($params){
            $req = $this->pdo->prepare($query);
            $req->execute($params);
        }
        else{
            $req = $this->pdo->query($query);
        }
        return $req;       
    }

    public function lastInsertID(){
        return $this->pdo->lastInsertID();
    }
}