<!DOCTYPE html>

 <html lang="en-us">
     <head>
        <meta charset="utf-8">
        <title><?php echo $itemData['invName']; ?> | Acme, Inc.</title>
        <meta name="description" content="CIT336 Acme Website">
        <meta name="author" content="Matthew Schaupp">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/acme/css/styles.css" type="text/css" rel="stylesheet" media="screen" />
        <link href="/acme/css/normalize.css" type="text/css" rel="stylesheet" media="screen" />
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
<!--             <header>
                 <h1></h1>
                 <hr>
             </header>-->
             
             <!--Add Content Here -->
             <?php if(isset($_SESSION['message'])){ echo $_SESSION['message']; } ?>
             
             <?php if(isset($itemDisplay)) {echo $itemDisplay;} ?>
             
             <?php if(isset($thumbnailDisplay)) {echo $thumbnailDisplay;} ?>
             
             <?php if(isset($reviewForm)) {echo $reviewForm;} ?>
             
             <?php if(isset($reviews)) {echo $reviews;} ?>
             
             <?php if(isset($reviewMessage)) {echo $reviewMessage;} ?>
         
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>
 
