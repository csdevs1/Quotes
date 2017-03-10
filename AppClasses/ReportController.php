<?php
    include('send_mail.php');
    class ReportController{
        function quote_error($msg,$id){
            // Report Quote's errors like: mispelled words, mispelled names...
            // $msg: User's comment to help solve the problem
            sendMail('error@portalquote.com',"An error has been reported - Quote: ".$id,$msg);
        }
        function offensive_quote($msg,$id){
            // Report Quote's errors like: mispelled words, mispelled names...
            // $msg: User's comment to help solve the problem
            sendMail('offensive@portalquote.com',"An offensive quote - Quote: ".$id,$msg);
        }
        function image($msg,$id){
            // Report Quote's errors like: mispelled words, mispelled names...
            // $msg: User's comment to help solve the problem
            sendMail('image@portalquote.com',"An offensive quote - Quote: ".$id,$msg);
        }
        
        // ========================================================================== //
        // ========================================================================== //
        
        function contact_us($msg){ // This can be used for "OTHERS" option
            // Report Quote's errors like: mispelled words, mispelled names...
            // $msg: User's comment to help solve the problem
            sendMail('contact@portalquote.com',"An offensive quote - Quote: ".$id,$msg);
        }
    }
?>