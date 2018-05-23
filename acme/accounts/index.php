<?php

/* 
 *Accounts Controller
 */

//Create or access a session
session_start();

//Get database connection file
require_once '../library/connections.php';
//Get the acme model for us as needed
require_once '../model/acme-model.php';
//Get the accounts model
require_once '../model/accounts-model.php';
//Get the reviews model
require_once '../model/reviews-model.php';
//Get functions
require_once '../library/functions.php';

//Get the array of categories
$categories = getCategories();
//var_dump($categories);
//exit;

////Build a navigation bar using the $categories array
//$navList = '<ul class="navigation">';
//$navList .= "<li><a href='/acme/index.php' title='View the Acme home page'>Home</a></li>";
//foreach ($categories as $category) {
//    $navList .= "<li><a href='/acme/index.php?action=".urlencode($category['categoryName'])."'
//        title='View our $category[categoryName] product
//        line'>$category[categoryName]</a></li>";
//}
//$navList .= '</ul>';
//echo $navList;
//exit;

//Call the buildNav function to build the navigation bar
$navList = buildNav($categories);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'login':
        include '../view/login.php';
        break;
    case 'registration':
        include '../view/registration.php';
        break;
    case 'register':
        //filter and store data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
         
        //Check for existing email address/username
        $checkedEmail = checkEmail($clientEmail);
        //Evaluate if email already exists and process accordingly
        if ($checkedEmail) {
            $message = '<p class="message">***Email address/Username already exits.  Please Login instead***</p>';
            include '../view/login.php';
            exit;
        }
        
        //Server-side email validation function call
        $clientEmail = valEmail($clientEmail);
        //Server-side password pattern validation function call
        $checkPassword = checkPassword($clientPassword);
        //var_dump($checkPassword);
        //exit;
        
        //missing data?
        if(empty($clientFirstname) || empty($clientLastname) || 
        empty($clientEmail) || empty($checkPassword)) {
            $message = '<p class="message">***Please provide information for all empty form fields.***</p>';
            include '../view/registration.php';
            exit;
        }
        
        //Hash the checked password so that it is not plain text in database
        $hashdedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        
        //send data to model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashdedPassword);
        
        //check and report results
        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $message = '<p class="message">***Thanks for registering ' . $clientFirstname. ' Please use your email and password to login.***</p>';
            include '../view/login.php';
            exit;
        } else {
            $message = '<p class="message">***Sorry ' . $clientFirstname . ' , but the registration failed.  Please try again.***</p>';
            include '../view/registration.php';
            exit;
        }
        break;
    case 'Login':
        //filter and store data input
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        
        //Server-side email validation function call
        $clientEmail = valEmail($clientEmail);
        //Server-side password validation function call
        $checkPassword = checkPassword($clientPassword);
        
        //missing data?
        if(empty($clientEmail) || empty($checkPassword)) {
            $message = '<p class="message">Please provide a valid email address and password.</p>';
            include '../view/login.php';
            exit;
        }
        
        //When valid password exists proceed with login
        //Query the client data based on the email address
        $clientData = getClient($clientEmail);
        //Compare the submitted password against the hashed password
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        //If the hashes don't match create an error and return to the login view
        if(!$hashCheck) {
            $message = '<p class="message">***Please check your password and try again.***</p>';
            include '../view/login.php';
            exit;
        }
        //A valid user exits, log them in
        $_SESSION['loggedin'] = TRUE;
        //Destroy firstname cookie
        setcookie('firstname', '', time() - 3600, '/');
        //Remove the password from the array.  The array_pop function removes the last element from an array
        array_pop($clientData);
        //print_r($clientData);
        //exit;
        
        //Store the array into the session
        $_SESSION['clientData'] = $clientData;
        //Build Variables for admin view
        $fullName = fullName();
        
        $userData = userData();
        //var_dump($userData);
        //exit;
        $productsLink = productsLink();
        //Variable to hold client reviews for admin view
        $clientReviews = buildClientReviews();
        //Send them to the admin view
        include '../view/admin.php';
        exit;
        break;
    case 'update':
        include '../view/client-update.php';
        break;
    case 'updateUserInfo':
        //filter and store data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        
        if ($_SESSION['clientData']['clientEmail'] != $clientEmail) {
            //Check for existing email address/username
            $checkedEmail = checkEmail($clientEmail);
            //Evaluate if email already exists and process accordingly
            if ($checkedEmail) {
                $message = '<p class="message">***Email address/Username already exits.  Please try again***</p>';
                include '../view/client-update.php';
                exit;
            }
            exit;
        }
        
        //Server-side email validation function call
        $clientEmail = valEmail($clientEmail);
        
        //missing data?
        if(empty($clientFirstname) || empty($clientLastname) || 
        empty($clientEmail)) {
            $message = '<p class="message">***Please provide information for all empty form fields.***</p>';
            include '../view/client-update.php';
            exit;
        }
        
        //send data to model
        $updateOutcome = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);
        
        //check and report results
        if ($updateOutcome) {
//            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $message = '<p class="message">***Update Successful!***</p>';
            $_SESSION['message'] = $message;
            $clientData = getUpdatedData($clientId);
            $_SESSION['clientData'] = $clientData;
            //Build Variables for admin view
            $fullName = fullName();
        
            $userData = userData();
            //var_dump($userData);
            //exit;
            $productsLink = productsLink();
            //Variable to hold client reviews for admin view
            $clientReviews = buildClientReviews();
            include '../view/admin.php';
            exit;
        } else {
            $message = '<p class="message">***Sorry ' . $clientFirstname . ' , but the update failed.  Please try again.***</p>';
            include '../view/client-update.php';
            exit;
        }
        break;
    case 'newPassword':
        //filter and store data
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        
        $checkPassword = checkPassword($clientPassword);
        //var_dump($checkPassword);
        //exit;
        
        //missing data?
        if (empty($checkPassword)) {
            $message2 = '<p class="message">***Error: Please provide information for all empty form fields.***</p>';
                include '../view/client-update.php';
                exit;
        }
        
        //Hash the checked password so that it is not plain text in database
        $hashdedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        
        //send data to model
        $updateOutcome = updatePassword($hashdedPassword, $clientId);
        
        //check and report results
        if ($updateOutcome) {
            $message = '<p class="message">***Password Changed Successfully!***</p>';
            $_SESSION['message'] = $message;
            //Build Variables for admin view
            $fullName = fullName();
        
            $userData = userData();
            //var_dump($userData);
            //exit;
            $productsLink = productsLink();
            //Variable to hold client reviews for admin view
            $clientReviews = buildClientReviews();
            include '../view/admin.php';
            exit;
        } else {
            $message2 = '<p class="message">***Sorry, but the change failed. Please try again.***</p>';
            include '../view/client-update.php';
            exit;
        }
        break;
    case 'Logout':
        $_SESSION['loggedin'] = FALSE;
        session_destroy();
        include '../index.php';
        break;
    default :
        if(isset($_SESSION['loggedin'])){
            if($_SESSION['loggedin']){
                $_SESSION['message'] = NULL;
                $fullName = fullName();
                $userData = userData();
                $productsLink = productsLink();
                //Variable to hold client reviews for admin view
                $clientReviews = buildClientReviews();
                include '../view/admin.php';}
            }
        else{
            include '../view/home.php';}
        break;
}

