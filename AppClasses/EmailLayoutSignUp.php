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
</html>