<?php
    require_once('AppController.php');
    require_once('Token.php');
    $token = new Token();
    class SocialNetwork{
        private $email;
        private $obj;
        public function __construct($email){
            $this->obj = new AppController();
            $this->email = $email;
        }

        public function checkUser(){
            if(isset($this->email) && !empty($this->email)){
                $user=$this->obj->find_by('users', 'email',sha1($this->email));
                return $user; //CHECK IF EMAIL EXIST WITH A SQL QUERY, IF NOT SAVE IN DB, ELSE LOGIN
            }
        }
    }

    if(isset($_POST['action'])=='check' && isset($_POST['token']) && $token->check($_POST['token'])){
        $obj=new SocialNetwork($_POST['email']);
        $json_response = array($obj->checkUser());
        echo json_encode($json_response);
    }else{
        echo 'Error 500';
    }
?>