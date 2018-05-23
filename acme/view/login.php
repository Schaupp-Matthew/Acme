<!DOCTYPE html>

<!--/* 
 * Login view
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
                 <h1>Acme Login</h1>
                 <hr>
             </header>
             
             <!--Add Content Here -->
             
             <!-- php error message code block -->
             <?php if (isset($message)) {echo $message;} ?>
             
             <form action="/acme/accounts/index.php" method="post">
                 <fieldset>
                     <legend>Login information:</legend>
                     <label for="clientEmail">Email Address</label><br>
                     <input class="Input" type="email" id="clientEmail" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required>
                     <br><br>
                     <label for="clientPassword">Password</label><br>
                     <span class="inputNote">**Password must be at least 8 characters long and have at least 1 uppercase character,
                            1 number, and 1 special character**</span><br>
                     <input class="Input" type="password" id="clientPassword" name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                     <br><br>
                     <input type="submit" class="Button" value="Login">
                     <input type="hidden" name="action" value="Login">
                 </fieldset>
             </form>
             <br>
             <p>Not a member?</p>
             <a href="../accounts/index.php?action=registration" title="Create an Account" id="registration">Create an Account</a>
        
         </main>     
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>
 