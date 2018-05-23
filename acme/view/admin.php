<?php
if(!$_SESSION['loggedin']){
    header('Location: /acme/index.php');
}
?>
<!DOCTYPE html>

<!--/* 
 * Admin View
 */-->

 <html lang="en-us">
     <head>
         <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/head.php';?>
     </head>
     <body>
         <header class="topHeader">
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/header.php';?>
         </header>
         <nav>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/navigation.php';?>
         </nav>
         <br>
         <main>
             <header>
                 <?php if(isset($fullName)){echo $fullName;} ?>
                 <hr>
             </header>
             
             <?php if(isset($_SESSION['message'])){echo $_SESSION['message'];} ?>
             
             <?php if(isset($message)) {echo $message;} ?>
             
             <?php if(isset($userData)){echo $userData;} ?>
             
             <?php if($_SESSION['clientData']['clientLevel'] > 1){echo $productsLink;} ?>
             
             <?php if(isset($clientReviews)){echo $clientReviews;} ?>
         
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>
