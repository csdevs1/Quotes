<?php
    include('send_mail.php');
    class ReportController{
        public function __construct($id,$msg){
            $this->id = $id;
            $this->msg = $msg;
        }
        
        function quote_error(){
            // Report Quote's errors like: mispelled words, mispelled names...
            // $msg: User's comment to help solve the problem
            return sendMail('error@portalquote.com',"An error has been reported - Quote ID: ".$this->id,$this->msg); //pass: o?yx6_ratB@i
        }
        function offensive_quote(){
            // Report Quote's errors like: mispelled words, mispelled names...
            // $msg: User's comment to help solve the problem
            return sendMail('offensive@portalquote.com',"An offensive quote has been reported - Quote ID: ".$this->id,$this->msg); // pass: U^Kwd.*b,3Cu
        }
        function image(){
            // Report Quote's errors like: mispelled words, mispelled names...
            // $msg: User's comment to help solve the problem
            return sendMail('image@portalquote.com',"Something's wrong with an image - Quote ID: ".$this->id,$this->msg); //pass: =V-6Tkc?SbJ-
        }
        
        // ========================================================================== //
        // ========================================================================== //
        
        function contact_us(){ // This can be used for "OTHERS" option
            // Report Quote's errors like: mispelled words, mispelled names...
            // $msg: User's comment to help solve the problem
            return sendMail('contact@portalquote.com',"You have a new message",$this->msg);
            //pass: kEktx#g!##O!
        }
    }
    if(isset($_POST['id']) && !empty($_POST['id']) && $_POST['action']=='report'){
        $id=$_POST['id'];
        $msg=$_POST['msg'];
        $opt=$_POST['t'];
        $obj=new ReportController($id,$msg);
        switch($opt) {
            case 0:
                $response=$obj->quote_error();
                break;
            case 1:
                $response=$obj->image();
                break;
            case 2:
                $response=$obj->offensive_quote();
                break;
            case 3:
                $response=$obj->contact_us();
                break;
            default:
                $error='Must select an option';
        }
        $json_response = array($response);
        echo json_encode($json_response);
    }
?>