<?php
/* 
 * Products controller
 */

//Create or access a session
session_start();

//Get database connection file
require_once '../library/connections.php';
//Get the acme model for use as needed
require_once '../model/acme-model.php';
//Get the products model for use
require_once '../model/products-model.php';
//Get the reviews model for use
require_once '../model/reviews-model.php';
//Get functions
require_once '../library/functions.php';
//Get the uploads model
require_once '../model/uploads-model.php';

//Get the array of categories
$categories = getCategories();
//Get the array of categoryName and categoryId
//$categoryNameId = getCategoryNameId();
//var_dump($categoryNameId);
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

$navList = buildNav($categories);

////Build a dynamic drop-down select list using the $categories array
//$catList = '<select name="categoryId" id="categoryId">';
//foreach ($categories as $nameId) {
//    $catList .= '<option value='.$nameId['categoryId'].'>'.$nameId['categoryName'].'</option>';
//}
//$catList .= '</select>';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'catView':
        include '../view/new-cat.php';
        break;
    
    case 'prodView':
        include '../view/new-prod.php';
        break;
    
    //To add the new category to the database
    case 'newCat':
        //filter and store input
        $categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);
        
        //missing data?
        if (empty($categoryName)) {
            $message = '<p class="message">***Please provide information for all empty form fields.***</p>';
            include '../view/new-cat.php';
            exit;
        }
        
        //send data to product-model
        $catOutcome = newCat($categoryName);
        
        //check and report results
        if ($catOutcome === 1) {
//            $message = "<p>***$categoryName has been added successfully!***</p>";
//            include '../view/new-cat.php';
            header('Location: /acme/products/index.php');
            exit;
        } else {
            $message = '<p class="message">***Sorry process failed.  Please try again.***</p>';
            include '../view/new-cat.php';
            exit;
        }
        break;
        
    //To add the new product to the database
    case 'newProd':
        //filter and store data
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_INT);
        $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_INT);
        $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
        $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
        $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
        
        //Server-side price, size, weight, and stock validation function calls
        $invPrice = valFloat($invPrice);
        $invSize = valInt($invSize);
        $invWeight = valInt($invWeight);
        $invStock = valInt($invStock);
        
        //Server-side price pattern validation call
//        $checkPrice = checkPricePattern($invPrice);  
//        var_dump($checkPrice);
//        exit;
        
        //missing data?
        if(empty($categoryId) || empty($invName) || 
        empty($invDescription) || empty($invImage) ||
        empty($invThumbnail) || empty($invPrice) || 
        empty($invStock) || empty($invSize) ||
        empty($invWeight) || empty($invLocation) || 
        empty($invVendor) || empty($invStyle)) {
            $message = '<p class="message">***Please provide information for all empty form fields.***</p>';
            include '../view/new-prod.php';
            exit;
        }
        
        //send data to products-model
        $prodOutcome = newProduct($categoryId, $invName, $invDescription, $invImage, $invThumbnail, $invPrice, 
                                $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle);
        
        //check and report results
        if ($prodOutcome === 1) {
            $message = '<p class="message">***' . $invName . ' has been added successfully!***</p>';
            $categoryId = NULL;
            $invName = NULL;
            $invDescription = NULL;
            $invImage = NULL;
            $invThumbnail = NULL;
            $invPrice = NULL;
            $invStock = NULL;
            $invSize = NULL;
            $invWeight = NULL;
            $invLocation = NULL;
            $invVendor = NULL;
            $invStyle = NULL;
            include '../view/new-prod.php';
            exit;
        } else {
            $message = '<p class="message">***Sorry process failed.  Please try again.***</p>';
            include '../view/new-prod.php';
            exit;
        }
        break;
    case 'mod':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $prodInfo = getProductInfo($invId);
        if (count($prodInfo) < 1) {
            $message = '***Sorry, no product information could be found.***';
        }
        include '../view/prod-update.php';
        exit;
        break;
    case 'updateProd':
        //filter and store data
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_INT);
        $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_INT);
        $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
        $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
        $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
        
        //Server-side price, size, weight, and stock validation function calls
        $invPrice = valFloat($invPrice);
        $invSize = valInt($invSize);
        $invWeight = valInt($invWeight);
        $invStock = valInt($invStock);
        
        //Server-side price pattern validation call
//        $checkPrice = checkPricePattern($invPrice);  
//        var_dump($checkPrice);
//        exit;
        
        //missing data?
        if(empty($categoryId) || empty($invName) || 
        empty($invDescription) || empty($invImage) ||
        empty($invThumbnail) || empty($invPrice) || 
        empty($invStock) || empty($invSize) ||
        empty($invWeight) || empty($invLocation) || 
        empty($invVendor) || empty($invStyle)) {
            $message = '<p class="message">***Please provide information for all empty form fields.***</p>';
            include '../view/prod-update.php';
            exit;
        }
        
        //send data to products-model
        $updateResult = updateProduct($categoryId, $invId, $invName, $invDescription, $invImage, $invThumbnail, $invPrice, 
                                $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle);
        
        //check and report results
        if ($updateResult) {
            $message = '<p class="message">***' . $invName . ' has been updated successfully!***</p>';
            $_SESSION['message'] = $message;
            header('Location: /acme/products/');
            exit;
        } else {
            $message = '<p class="message">***Sorry, the process failed.  Please try again.***</p>';
            include '../view/prod-update.php';
            exit;
        }
        break;
    case 'del':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $prodInfo = getProductInfo($invId);
        if (count($prodInfo) < 1) {
            $message = '***Sorry, no product information could be found.***';
        }
        include '../view/prod-delete.php';
        exit;
        break;
    case 'deleteProd':
        //filter and store data
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        
        //send data to products-model
        $deleteResult = deleteProduct($invId);
        
        //check and report results
        if ($deleteResult) {
            $message = '<p class="message">***' . $invName . ' has been successfully deleted!***</p>';
            $_SESSION['message'] = $message;
            header('Location: /acme/products/');
            exit;
        } else {
            $message = '<p class="message">***Error: ' . $invName . ' was not successfully deleted!***</p>';
            $_SESSION['message'] = $message;
            header('Location: /acme/products/');
            exit;
        }
        break;
    case 'category':
        //Filter, sanatize, and store second name value pair for GET
        $type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
        //Variable to store array of products returned from model
        $products = getProductsByCategory($type);
        //Clear session messsage variable
        $_SESSION['message'] = NULL;
        //Were any products returned?
        if(!count($products)){
            $message = "<p class='message'>Sorry, no $type products could be found.</p>";
            } else {
            $prodDisplay = buildProductsDisplay($products);
            }
//        echo $prodDisplay;
//        exit;
        include '../view/category.php';
        break;
    case 'item':
        //Filter, sanatize, and store second name value pair for GET
        $invId = filter_input(INPUT_GET, 'item', FILTER_SANITIZE_NUMBER_INT);
        //Variable to store array of item's data from model
        $itemData = getItemData($invId);
        //Variable to store array of thumbnail image paths for item
        $thumbnailData = getThumbnails($invId);
        //Verify data returned for thumbnails.  If so call function to build view.
        if($thumbnailData){
            $thumbnailDisplay = buildThumbnailDisplay($thumbnailData);
        }    
        //Verify data returned.  If not set message.
        if(!count($itemData)){
            $message = "<p class='message'>Sorry, Product is out of stock.  Sorry for the inconvenience!";
        } else {
            $itemDisplay = buildItemDisplay($itemData);
        }
        //Variable to hold the review display
        $reviewForm = '<hr><h3>Customer Reviews:</h3>';
        if(!isset($_SESSION['loggedin'])){
            $reviewForm .= '<p class="message">You can add a review by logging in --> <a href="../accounts/index.php?action=login">Login!</a></p>';
        }
        else {
            $screenName = substr($_SESSION['clientData']['clientFirstname'],0,1);
            $screenName .= $_SESSION['clientData']['clientLastname'];
            
            $reviewForm .= '<h4>Review the ' . $itemData['invName'] . '!</h4>';
            $reviewForm .= '<form method="post" action="/acme/reviews/index.php">';
            $reviewForm .= '<fieldset><legend>Review Form: All fields required!</legend><br>';
            $reviewForm .= '<label>Screen Name:</label><br>';
            $reviewForm .= '<input class="Input" type="text" id="screenName" name="screenName" value="' . $screenName . '" readonly><br><br>';
            $reviewForm .= '<label>Review:</label><br>';
            $reviewForm .= '<textarea rows="10" cols="25" class="Input" id="reviewText" name="reviewText" required></textarea><br><br>';
            $reviewForm .= '<input type="submit" name="submit" value="Submit Review" class="Button">';
            $reviewForm .= '<input type="hidden" name="invId" value="' . $invId . '" >';
            $reviewForm .= '<input type="hidden" name="clientId" value="' . $_SESSION['clientData']['clientId'] . '" >';
            $reviewForm .= '<input type="hidden" name="action" value="newReview" ></fieldset></form>';
        }
        //Variable to hold the item reviews
        $itemReviews = getItemReviews($invId);
        //Check if reviews were returned
        if(!count($itemReviews)) {
            $reviewMessage = '<h4>Be the first to review this product!</h4>';
        }
        else {
            $reviews = buildReviewsDisplay($itemReviews);
        }
        include '../view/product-detail.php';
        break;
    default :
        $products = getProductBasics();
        if(count($products) > 0){
                $className = 'white';
                $prodList = '<table>';
                $prodList .= '<thead>';
                $prodList .= '<tr><th>Product Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
                $prodList .= '</thead>';
                $prodList .= '<tbody>';
                foreach ($products as $product) {
                    if ($className == 'white') {
                        $className = 'shade';
                    } else {
                        $className = 'white';
                    }
                    $prodList .= "<tr class=$className><td>$product[invName]</td>";
                    $prodList .= "<td><a href='/acme/products?action=mod&id=$product[invId]' title='Click to modify'>Modify</a></td>";
                    $prodList .= "<td><a href='/acme/products?action=del&id=$product[invId]' title='Click to delete'>Delete</a></td></tr>";
                }
                $prodList .= '</tbody></table>';
        } else {
        $message = '<p class="notify">***Sorry, no products were returned.***</p>';
        }
        
        include '../view/prod-mgmt.php';
        break;
}