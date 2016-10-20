<?php
    require_once('AppController.php');
    session_start();
    class User{
        private $data;
        private $table;
        private $token;
        private $obj;
        private $user; // Username or Email to login
        private $passwd; // Password to login
        public function __construct($table='',$data=''){
            $this->obj = new AppController();
            $this->token = new Token();
            $this->data = $data;
            $this->table = $table;
        }
        
        public function signup($token){
            if($this->token->check($token)){
                if($this->data['gender']=='F'){
                    $this->data['picture']='/images/profile/female.png';
                }else{
                    $this->data['picture']='/images/profile/male.png';
                }
                foreach($this->data as $key => $val){
                    if($key=='passwd'){
                        $val=sha1($val);
                    }
                    $cols[]=$key;
                    $vals[]='"'.str_replace('"','\"',$val).'"';
                }
                $col = implode(", " , $cols);
                $val= implode(", " , $vals);
                $response=$this->obj->save($table,$col,$val);
                return $response;
            } else{
                return false;
            }
        }
        public function signin($user,$passwd){}
        public function checkUser($user){} // Check Current User against the User's panel
    }
?>