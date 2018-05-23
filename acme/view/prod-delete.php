<?php
if($_SESSION['clientData']['clientLevel'] < 2){
    header('Location: /acme/index.php');
}
?>
<!DOCTYPE html>

<!--/* 
 * New Product View
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
                 <h1><?php if(isset($prodInfo['invName'])){ echo "Delete $prodInfo[invName]?";} ?></h1>
                 <hr>
             </header>
             
             <!--Add Content Here -->
             <p class="message">***Confirm Product Deletion. The delete is permanent!***</p>
             
             <!-- success/error message code block -->
             <?php if (isset($message)) {echo $message;} ?>
             
             <form method="post" action="/acme/products/index.php">
                 <fieldset>
                     <legend>Product Information:</legend>
                     <br>
                     <label for="invName">Product Name</label><br>
                     <input class="Input" type="text" readonly id="invName" name="invName" <?php if(isset($prodInfo['invName'])) {echo "value='$prodInfo[invName]'"; } ?> required>
                     <br><br>
                     <label for="invDescription">Product Description</label><br>
                     <textarea rows="10" cols="25" class="Input" readonly id="invDescription" name="invDescription" required><?php if(isset($prodInfo['invDescription'])) {echo $prodInfo['invDescription']; } ?></textarea>
                     <br><br>
                     <input type="submit" name="submit" class="" value="Delete Product">
                     <!-- Add action name - value pair -->
                     <input type="hidden" name="action" value="deleteProd" >
                     <input type="hidden" name="invId" value="<?php if(isset($prodInfo['invId'])){ echo $prodInfo['invId'];} ?>">
                 </fieldset>
             </form>
         
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>



