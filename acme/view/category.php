<!DOCTYPE html>

 <html lang="en-us">
     <head>
        <meta charset="utf-8">
        <title><?php echo $type; ?> Products | Acme, Inc.</title>
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
                 <h1><?php echo $type; ?> Products</h1>
                 <hr>
             </header>
             
             <?php if(isset($message)){ echo $message; } ?>
             
             <?php if(isset($prodDisplay)){ echo $prodDisplay; } ?>
         
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>
 
