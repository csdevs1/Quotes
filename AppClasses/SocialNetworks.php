<?php
    require_once('AppController.php');
    require_once('Token.php');
    $token = new Token();
    session_start();
    class SocialNetwork{
        private $email;
        private $obj;
        public function __construct($email){
            $this->obj = new AppController();
            $this->email = $email;
        }
        
        private function checkUser(){
            if(isset($this->email) && !empty($this->email)){
                $user=$this->obj->find_by('users', 'email',$this->email);
                return $user;
            }
        }
        
        public function signup($oauth_provider='',$oauth_id='',$fname='',$lname='',$gender='',$picture=''){
            $checked=$this->checkUser();
            if(isset($checked[0]) && !empty($checked[0])){
                login($checked[0]['email']);
            } else{
                $uname=substr($this->email, 0, strpos($this->email, "@"));
                $col="oauth_provider,oauth_uid,fname,lname,email,username,gender,picture,passwd";
                $val="'".$oauth_provider."','".$oauth_id."','".$fname."','".$lname."','".$this->email."','".$uname."','".$gender."','".$picture."',''";
                if($this->obj->save('users',$col,$val)){
                    $this->login($uname);
                }
            }
        }
        
        public function login($uname){
            return 'logged';
        }
    }
?>