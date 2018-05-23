<?php
if(!$_SESSION['loggedin']){
    header('Location: /acme/index.php');
}
?>
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
                 <h1>Update Account</h1>
                 <hr>
             </header>
             
             <!--Add Content Here -->
             <p>Use this form to update your name or email information.</p>
            
             <!-- php error message code block -->
             <?php if (isset($message)) {echo $message;} ?>
             
             <form action="/acme/accounts/index.php" method="post">
                 <fieldset>
                     <legend>Personal information:</legend>
                     <label for="clientFirstname">First name</label><br>
                     <input class="Input" type="text" id="clientFirstname" name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} elseif(isset($_SESSION['clientData']['clientFirstname'])) {echo "value='" . $_SESSION['clientData']['clientFirstname'] . "'";} ?> required>
                     <br><br>
                     <label for="clientLastname">Last name</label><br>
                     <input class="Input" type="text" id="clientLastname" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} elseif(isset($_SESSION['clientData']['clientLastname'])) {echo "value='" . $_SESSION['clientData']['clientLastname'] . "'";} ?> required>
                     <br><br>
                     <label for="clientEmail">Email Address</label><br>
                     <input class="Input" type="email" id="clientEmail" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} elseif(isset($_SESSION['clientData']['clientEmail'])) {echo "value='" . $_SESSION['clientData']['clientEmail'] . "'";} ?> required>
                     <br><br>
                     <input type="submit" name="submit" class="Button" value="Update">
                     <!-- Add action name - value pair -->
                     <input type="hidden" name="action" value="updateUserInfo" >
                     <input type="hidden" name="clientId" value="<?php if(isset($_SESSION['clientData']['clientId'])){ echo $_SESSION['clientData']['clientId'];} 
                                                                    elseif(isset($clientId)){ echo $clientId; } ?>">
                 </fieldset>
             </form>
             
             <header>
                 <h1>Password Change</h1>
                 <hr>
             </header>
             
             <!--Add Content Here -->
             <p>Use this form to change your password.</p>
            
             <!-- php error message code block -->
             <?php if (isset($message2)) {echo $message2;} ?>
             
             <form action="/acme/accounts/index.php" method="post">
                 <fieldset>
                     <legend>Password:</legend>
                     <label for="clientPassword">New Password</label><br>
                     <span class="inputNote">**New password must be at least 8 characters long and have at least 1 uppercase character,
                            1 number, and 1 special character**</span><br>
                     <input class="Input" type="password" id="clientPassword" name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                     <br><br>
                     <input type="submit" name="submit" class="Button" value="Change Password">
                     <!-- Add action name - value pair -->
                     <input type="hidden" name="action" value="newPassword" >
                     <input type="hidden" name="clientId" value="<?php if(isset($_SESSION['clientData']['clientId'])){ echo $_SESSION['clientData']['clientId'];} 
                                                                    elseif(isset($clientId)){ echo $clientId; } ?>">
                 </fieldset>
             </form>
             
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>
 

