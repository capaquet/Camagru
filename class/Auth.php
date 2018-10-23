<?php

class Auth{
 
    private $options = [
        'restriction_msg' => "Vous n'avez pas le droit d'accéder à cette page."
    ];
    private $session;

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
        
        Email::send($user_id, $email, $token);
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
        if(!$this->session->read('auth')){
            $this->session->setFlash('danger', $this->options['restriction_msg']);
            App::redirect('login.php');
            exit();  
        }
    }

    public function user(){
        if(!$this->session->read('auth')){
            return false;
        }
        return $this->session->read('auth');
    }

    public function connect($user){
        $this->session->write('auth', $user);
    }

    public function connect_from_cookie($db){
//        if (isset($_COOKIE['remember']) && !$this->user){
        if (isset($_COOKIE['remember']) && !$this->session->read('user')){
            $remember_token = $_COOKIE['remember'];
            $split = explode('==', $remember_token);
            $user_id = $split[0];
            require '/app/config/info_db.php';
            $user = $db->query("SELECT * FROM " .$db_config['db_name'].".".$db_config['user_table']. " WHERE id = ?", [$user_id])->fetch();
            if ($user){
                $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'camagru');
                if ($expected == $remember_token){
                    $this->connect($user);
                    $_SESSION['auth'] = $user;
                    setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
                }
            }
            else{
                setcookie('remember', NULL, -1);
            }
        }
        else{
            setcookie('remember', NULL, -1);
        }
    }
 
    public function remember($db, $user_id){
        require '/app/config/info_db.php';
        $remember_token = Str::random(250);
        $db->query('UPDATE ' .$db_config['db_name'].".".$db_config['user_table']. " SET remember_token = ? WHERE Id = ?",[$remember_token, $user->id]);
        setcookie('remember', $user_id . '==' . $remember_token . sha1($user_id.'camagru'), time() + 60 * 60 * 24 * 7);
    }

    public function login($db, $username, $password, $remember = false){
        require '/app/config/info_db.php';
        $user = $db->query("SELECT * FROM " .$db_config['db_name'].".".$db_config['user_table']. " WHERE (username = :username OR email = :username)",['username' => $username])->fetch();
        if($user && password_verify($_POST['password'], $user->password)){
            $this->connect($user);
            if ($remember){
                $this->remember($db, $user->id);
            }
            return $user;
        }
        else{
            return false;
        }
    }

    public function logout(){
        setcookie('remember', NULL, -1);
        $this->session->delete('auth');
    }

    public function resetPassword($db, $email){
        require '/app/config/info_db.php';    
        $user = $db->query("SELECT * FROM ".$db_config['db_name'].".".$db_config['user_table']." WHERE email = ? AND confirmation_date IS NOT NULL", $email)->fetch();
        if($user){
            $reset_token = Str::random(60);
            $db->query("UPDATE ".$db_config['db_name'].".".$db_config['user_table']." SET reset_token = ?, reset_date = NOW() WHERE id = ?", [$reset_token, $user->id]);
            mail($_POST['email'], "Réinitialisation du mot de passe", "merci de cliquer coco !\n\nlocalhost/reset.php?id={$user->id}&token=$reset_token");
            return $user;
        }
        return false;
    }

    public function getUserFromToken($db, $user_id, $token){
        return $db->query('SELECT * FROM '.$db_config['db_name'].'.'.$db_config['user_table'].' WHERE id = ? AND token = ? AND reset_date > DATE_SUB(NOW() INTERVAL 30 MINUTE)', [$user_id, $token])->fetch();
    }

    public function hashPassword($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }
}