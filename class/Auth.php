<?php

class Auth{
 
    public function register($db, $username, $password, $email){
        $token = Str::random(60);
        $password = password_hash($password, PASSWORD_BCRYPT);
        require '/app/config/info_db.php';         
        $db->query("INSERT INTO ".$db_config['db_name'].".".$db_config['user_table']." SET username= ?, password = ?, email = ?, confirmation_token = ?",[
             $username,
            $password,
            $email,
            $token
        ]);      
        $user_id = $db->lastInsertID();

        mail($email, "Confirmation du compte", "merci de cliquer coco !\n\nlocalhost/confirm.php?id=$user_id&token=$token");
    }

    public function confirm($db, $user_id, $token, $session){

        $db->query("SELECT * FROM " . $db_config['db_name'] . "." .$db_config['user_table'] . " WHERE id = ?", [$user_id])->fetch();
        if ($user && $user->confirmation_token == $token){
            $db->query("UPDATE " . $db_config['db_name'] . "." .$db_config['user_table'] . " SET confirmation_token = NULL, confirmation_date = NOW() WHERE id = ?", [$user_id]);
            $session->write('auth', $user);
            return true;
        }
        else{
            return false;
        }
    }

    public function restrict($session){
        if(!$session->read(['auth'])){
            $session->setFlash('danger', "Vous n'avez pas le droit d'accéder à cette page.");
            App::redirect('login.php');
            exit();
        }
    }
}