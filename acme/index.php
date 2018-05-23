<?php

/* 
 * Acme Controller
 */

//Create or access a session
session_start();

//Get database connection file
require_once 'library/connections.php';
//Get the acme model for us as needed
require_once 'model/acme-model.php';
//Get functions
require_once 'library/functions.php';

//Get the array of categories
$categories = getCategories();
//var_dump($categories);
//exit;

//Build a navigation bar using the $categories array
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

$navList = buildNav($categories);

//Build a dynamic drop-down select list using the $categories array
//$catList = '<select name="product categories">';
//foreach ($categories as $nameId) {
//    $catList .= '<option value='.$nameId['categoryId'].'>'.$nameId['categoryName'].'</option>';
//}
//$catList .= '</select>';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

//Check for existance of cookie and process
if(isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}
//var_dump($cookieFirstname);
//exit;

switch ($action) {
    case 'template':
        include 'view/template.php';
        break;
    default :
        include 'view/home.php';
}

