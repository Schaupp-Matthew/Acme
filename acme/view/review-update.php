<!DOCTYPE html>

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
                 <h1>Review Update</h1>
                 <hr>
             </header>
             
             <!--Add Content Here -->
             <?php if(isset($message)) {echo $message;} ?>
             
             <form method="post" action="/acme/reviews/index.php">
                 <fieldset><legend>Review Update Form: All fields required!</legend><br>
                     <label for='screenName'>Screen Name:</label><br>
                     <input class="Input" type="text" id="screenName" readonly <?php if(isset($screenName)) {echo "value='$screenName'";} ?> >
                     <br><br>
                     <label for="reviewText">Review:</label><br>
                     <textarea rows="10" cols="30" class="Input" id="reviewText" name="reviewText" required><?php if(isset($review['reviewText'])) {echo $review['reviewText']; } elseif (isset ($reviewText)) {echo $reviewText;} ?></textarea>
                     <br><br>
                     <input type="submit" name="submit" class="" value="Update Review">
                     <!-- Add action name - value pair -->
                     <input type="hidden" name="action" value="updateReview" >
                     <input type="hidden" name="reviewId" value="<?php if(isset($review['reviewId'])){ echo $review['reviewId'];} elseif(isset ($reviewId)) {echo $reviewId;} ?>">
                 </fieldset>
             </form>
         
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>
 
