<?php

/* 
 * Reviews Controller
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

$navList = buildNav($categories);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'newReview':
        //filter and store data
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        
        //missing data?
        if(empty($reviewText) || empty($invId) || empty($clientId)) {
            $_SESSION['message'] = '<p class="message">***Please provide information for all empty form fields.***</p>';
            header("Location: /acme/products/?action=item&item=$invId");
            exit;
        }
        
        //send data to products-model
        $reviewOutcome = insertReview($reviewText, $invId, $clientId);
        
        //check and report results
        if ($reviewOutcome === 1) {
            $_SESSION['message'] = '<p class="message">***Review has been added successfully!***</p>';
            $reviewText = NULL;
            header("Location: /acme/products/?action=item&item=$invId");
            exit;
        } else {
            $_SESSION['message'] = '<p class="message">***Sorry process failed.  Please try again.***</p>';
            header("Location: /acme/products/?action=item&item=$invId");
            exit;
        }
        break;
    case 'editReview':
        //filter and store data
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        
        //Variable to store reviewText for specific review
        $review = specificReview($reviewId);
        
        $screenName = substr($_SESSION['clientData']['clientFirstname'],0,1);
        $screenName .= $_SESSION['clientData']['clientLastname'];
        
        //check and report results
        if (!isset($review)) {
            $message = '<p class="message">***Sorry, there was an error.  Please contact site admin.</p>';
        }
        include '../view/review-update.php';
        break;
    case 'updateReview':
        //filter and store data
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        
        //Variable to store reviewText for specific review
        $review = specificReview($reviewId);
        $date = NULL;
        
        $screenName = substr($_SESSION['clientData']['clientFirstname'],0,1);
        $screenName .= $_SESSION['clientData']['clientLastname'];
        
        //missing data?
        if(empty($reviewId) || empty($reviewText)) {
            $message = '<p class="message">***No empty fields allowed.  Please provide update below.***</p>';
            include '../view/review-update.php';
            exit;
        }
        
        //send data to products-model
        $updateResult = updateReview($reviewId, $reviewText, $date);
        
        //check and report results
        if ($updateResult) {
            $message = '<p class="message">***Update has been successful!***</p>';
//            $_SESSION['message'] = $message;
            $fullName = fullName();
            $userData = userData();
            $productsLink = productsLink();
            //Variable to hold client reviews for admin view
            $clientReviews = buildClientReviews();
            include '../view/admin.php';
//            header('Location: /acme/view/admin.php');
            exit;
        } else {
            $message = '<p class="message">***Sorry, the process failed.  Please try again.***</p>';
            include '../view/review-update.php';
            exit;
        }
        break;
    case 'confirmDeletion':
        //filter and store data
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        
        //Variable to store reviewText for specific review
        $review = specificReview($reviewId);
        
        $message = '<p class="message">***WARNING:  Deletion can not be undone.  Are you sure you want to delete?***</p>';
        
        $screenName = substr($_SESSION['clientData']['clientFirstname'],0,1);
        $screenName .= $_SESSION['clientData']['clientLastname'];
        
        //check and report results
        if (!isset($review)) {
            $message = '<p class="message">***Sorry, there was an error.  Please contact site admin.</p>';
        }
        include '../view/review-delete.php';
        break;
    case 'deleteReview':
        //filter and store data
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        
        //Variable to store reviewText for specific review
        $review = specificReview($reviewId);
//        $date = NULL;
        
        $screenName = substr($_SESSION['clientData']['clientFirstname'],0,1);
        $screenName .= $_SESSION['clientData']['clientLastname'];
        
        //missing data?
        if(empty($reviewId)) {
            $message = '<p class="message">***Process failed. Please try again.***</p>';
            include '../view/review-delete.php';
            exit;
        }
        
        //send data to products-model
        $deleteResult = deleteReview($reviewId);
        
        //check and report results
        if ($deleteResult) {
            $message = '<p class="message">***Deletion has been successfully!***</p>';
//            $_SESSION['message'] = $message;
            $fullName = fullName();
            $userData = userData();
            $productsLink = productsLink();
            //Variable to hold client reviews for admin view
            $clientReviews = buildClientReviews();
            include '../view/admin.php';
//            header('Location: /acme/view/admin.php');
            exit;
        } else {
            $message = '<p class="message">***Sorry, the process failed.  Please try again.***</p>';
            include '../view/review-delete.php';
            exit;
        }
        break;
    default :
        if(isset($_SESSION['loggedin'])){
            if($_SESSION['loggedin']){
                $fullName = fullName();
                $userData = userData();
                $productsLink = productsLink();
                include '../view/admin.php';}
            }
        else{
            include '../view/home.php';}
        break;
}