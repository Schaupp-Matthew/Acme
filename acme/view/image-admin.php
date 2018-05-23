<?php if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
} ?>
<!DOCTYPE html>

 <html lang="en-us">
     <head>
        <meta charset="utf-8">
    <title>Image Management</title>
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
             <header>
                 <h1>Image Management</h1>
                 <hr>
             </header>
             
             <!--Add Content Here -->
            <p>Welcome to Image Management!  Choose one of the options presented below:</p>
            
            <h2>Add New Product Image</h2>
            <?php
            if (isset($message)) {
            echo $message;
            }
            ?>
            <form action="/acme/uploads/" method="post" enctype="multipart/form-data">
             <label for="invItem">Product</label><br>
             <?php echo $prodSelect; ?><br><br>
             <label>Upload Image:</label><br>
             <input type="file" name="file1"><br>
             <input type="submit" class="regbtn" value="Upload">
             <input type="hidden" name="action" value="upload">
            </form>
            
            <hr>
            
            <h2>Existing Images</h2>
            <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
            <?php
            if (isset($imageDisplay)) {
             echo $imageDisplay;
            }
            ?>
         
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>
 <?php unset($_SESSION['message']); ?>