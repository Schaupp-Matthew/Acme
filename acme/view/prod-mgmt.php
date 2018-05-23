<?php
if($_SESSION['clientData']['clientLevel'] < 2){
    header('Location: /acme/index.php');
    exit;
}
if(isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
?>
<!DOCTYPE html>

<!--/* 
 * Product Management View
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
                 <h1>Product Management</h1>
                 <hr>
             </header>
             
             <!--Add Content Here -->
             <p>Welcome to the product management page.  Please choose an option below:</p>
             
             <ul>
                 <li><a href="/acme/products/index.php?action=catView">Add a New Category</a></li>
                 <li><a href="/acme/products/index.php?action=prodView">Add a New Product</a></li>
             </ul>
             
            <?php
            if (isset($message)) {
             echo $message;
            } if (isset($prodList)) {
             echo $prodList;
            }
            ?>
         
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>
 <?php unset($_SESSION['message']); ?>