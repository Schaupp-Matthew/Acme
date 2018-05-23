<?php
if($_SESSION['clientData']['clientLevel'] < 2){
    header('Location: /acme/index.php');
}
?>
<!DOCTYPE html>

<!--/* 
 * New Category View
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
                 <h1>Add Category</h1>
                 <hr>
             </header>
             
             <!--Add Content Here -->
             <p>Add a new category below:</p>
             
             <!-- success/error message code block -->
             <?php if (isset($message)) {echo $message;} ?>
             
             <form method="post" action="/acme/products/index.php">
                 <fieldset>
                     <legend>Category Information:</legend>
                     <br>
                     <label for="categoryName">New Category Name</label><br>
                     <input class="Input" type="text" id="categoryName" name="categoryName" required>
                     <br><br>
                     <input type="submit" name="submit" class="" value="Add Category">
                     <!-- Add action name - value pair -->
                     <input type="hidden" name="action" value="newCat" >
                 </fieldset>
             </form>
         
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>

