<!DOCTYPE html>

<!--Registration View-->

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
                 <h1>Acme Registration</h1>
                 <hr>
             </header>
             
             <!--Add Content Here -->
             <p>All fields are required.</p>
            
             <!-- php error message code block -->
             <?php if (isset($message)) {echo $message;} ?>
             
             <form action="/acme/accounts/index.php" method="post">
                 <fieldset>
                     <legend>Personal information:</legend>
                     <label for="clientFirstname">First name</label><br>
                     <input class="Input" type="text" id="clientFirstname" name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?> required>
                     <br><br>
                     <label for="clientLastname">Last name</label><br>
                     <input class="Input" type="text" id="clientLastname" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?> required>
                     <br><br>
                     <label for="clientEmail">Email Address</label><br>
                     <input class="Input" type="email" id="clientEmail" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required>
                     <br><br>
                     <label for="clientPassword">Password</label><br>
                     <span class="inputNote">**Password must be at least 8 characters long and have at least 1 uppercase character,
                            1 number, and 1 special character**</span><br>
                     <input class="Input" type="password" id="clientPassword" name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                     <br><br>
                     <input type="submit" name="submit" class="Button" value="Register">
                     <!-- Add action name - value pair -->
                     <input type="hidden" name="action" value="register" >
                 </fieldset>
             </form>
             
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>
 

