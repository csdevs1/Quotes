<?php
    require_once('AppController.php');
    include('send_mail.php');
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
                $response=$this->obj->save($this->table,$col,$val);
                if($response){
                    $user=$this->obj->find_by('users','email',$this->data['email']);
                    $digest = sha1($user[0]['userID']);
                    $response2=$this->obj->save('pswd_digest','userID,digest',"'".$user[0]['userID']."','".$digest."'");
                    if($response2){
                        $digest=$this->obj->find_by('pswd_digest','userID',$user[0]['userID']);
                        $this->contact_mail($user[0]['email'],$user[0]['fname'],$digest[0]['digest']);
                        return $response2;
                    }
                }
            } else{
                return false;
            }
        }
        public function signin($user,$passwd){}
        public function checkUser($user){} // Check Current User against the User's panel
        
         private function contact_mail($email,$user,$digest){
            $msg="
             <html>
     <head>
         <link href='https://fonts.googleapis.com/css?family=Tangerine' rel='stylesheet'>
         <style>
             body{font-size: 16px !important;}
             div{
                 position: relative !important;
                 height: 100% !important;
                 text-align: center !important;
             }
             h1{
                 width: 100% !important;
                 word-spacing: 15px !important;
                 text-shadow: -4px 2px 10px #ccc !important;
                 color: #000 !important;
                 font-family: 'Tangerine', 'cursive' !important;
                 font-size: 2.5rem !important;
             }
             p{
                 font-size: 1.2rem !important;font-family: 'Courier New' !important;
             }
             a{
                 text-decoration: none !important;display: block !important;
                 padding:10px !important;
                 background: #995fff !important;
                 color: #fff !important;
                 width: 15% !important;
                 margin-left: auto !important;
                 margin-right: auto !important;
                 margin-top: 10px !important;
                 font-size: 1.2rem !important;font-family: 'Verdana' !important;
             }
             .img{width: 250px;cursor:default !important;}
             .a6S{display: none !important;}
         </style>
     </head>
     <body>
         <div>
             <img class='img' src='https://i.imgur.com/jQrSxJ7.png'>
             <h1>Welcome ".$user."</h1>
             <p>Click on the following button to continue with your account verification: <a href='localhost/verification/".$digest."'>Verify your account.</a></p>
         </div>
     </body>
</html>";
            sendMail($email,'Welcome to PortalQuote',$msg);
        }
    }
?>