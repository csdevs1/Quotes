<?php
    require_once('AppController.php');
    require_once('Token.php');
    class User{
        private $data;
        private $table;
        private $token;
        private $obj;
        public function __construct($table='',$data=''){
            $this->obj = new AppController();
            $this->token = new Token();
            $this->data = $data;
            $this->table = $table;
        }
        
        public function signup($token){
            if($this->token->check($token)){
                foreach($this->data as $key => $val){
                    if($key=='usrPswd' || $key=='usrName'){
                        $val=sha1($val);
                    }
                    $cols[]=$key;
                    $vals[]='"'.str_replace('"','\"',$val).'"';
                }
                $col = implode(", " , $cols);
                $val= implode(", " , $vals);
                $response=$this->obj->save($this->table,$col,$val);
                if($response){
                    return $response;
                }
            } else{
                return false;
            }
        }
    }
    if(isset($_POST['table']) && !empty($_POST['data']) && $_POST['action']=='signup' && !empty($_POST['token'])){ //check Token function
        $table = $_POST['table'];
        $token = $_POST['token'];
        $data = json_decode($_POST['data'],true);
        $user=new User($table,$data);
        $response=$user->signup($token);
        if($response){
            $json_response = array('response'=>200,$response);
            echo json_encode($json_response);
        } else{
            $json_response = array('response'=>400,$response);
            echo json_encode($json_response);
        }
    }
?>