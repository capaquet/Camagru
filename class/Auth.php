<?php

class Auth{
 
    private $options = [
        'restriction_msg' => "Vous n'avez pas le droit d'accéder à cette page."
    ];
    private $sessinon;

    public function __construct($session, $options = []){
        $this->options = array_merge($this->options, $options);
        $this->session = $session;
    }

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

    public function confirm($db, $user_id, $token){

        require '/app/config/info_db.php';
        $user = $db->query("SELECT * FROM " . $db_config['db_name'] . "." .$db_config['user_table'] . " WHERE id = ?", [$user_id])->fetch();
        if ($user && $user->confirmation_token == $token){
            $db->query("UPDATE " . $db_config['db_name'] . "." .$db_config['user_table'] . " SET confirmation_token = NULL, confirmation_date = NOW() WHERE id = ?", [$user_id]);
            $this->session->write('auth',  $user);
            return true;
        }
        else{
            return false;
        }
    }

    public function restrict(){
        if(!$this->session->read(['auth'])){
            $this->session->setFlash('danger', $this->options['restriction_msg']);
            App::redirect('login.php');
            exit();
        }
    }

    public function connectFromCookie()
    {
        
    }
}