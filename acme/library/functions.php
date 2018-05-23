<?php

/* 
 * CUSTOM FUNCTIONS
 */

//For server-side validation of email address input
function valEmail($clientEmail) {
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

//For server-side validation of float input
function valFloat($inputItem) {
    $valFloat = filter_var($inputItem, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    return $valFloat;
}

//For server-side validation of inventory price
function valInt($inputItem) {
    $valInt = filter_var($inputItem, FILTER_VALIDATE_INT);
    return $valInt;
}

//For server-side validation of password input pattern
function checkPassword($clientPassword) {
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])[[:print:]]{8,}$/'; //(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$
    return preg_match($pattern, $clientPassword);
}

//For server-side validation of price input pattern
//function checkPricePattern($invPrice) {
//    //$pattern = '/^([0-9]+\.[0-9]{2}?)$/';  //(\d+\.\d{2})
//    //$pattern = '/^[0-9]+\.([0-9]{2,})$/';  //(\d+\.\d{2})
//    //$pattern = '/^([1-9][0-9]*|0)(\.[0-9]{2})?$/';
//    $pattern = '/^(\d{1,10})[.](\d{2})$/';
//    return preg_match($pattern, $invPrice);
//}

//For building the navigation bar dynamically
function buildNav($categories) {
    //Build a navigation bar using the $categories array
    $navList = '<ul class="navigation">';
    $navList .= "<li><a href='/acme/' title='View the Acme home page'>Home</a></li>";
    foreach ($categories as $category) {
        $navList .= "<li><a href='/acme/products/?action=category&type=$category[categoryName]'".
            " title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
    }
    $navList .= '</ul>';
    return $navList;
}

function fullName() {
    $fullName = '<h1>' . $_SESSION['clientData']['clientFirstname'] . ' ' . $_SESSION['clientData']['clientLastname'] . '</h1>';
    return $fullName;
}

function userData() {
    $userData = '<p>You are logged in!</p>';
    $userData .= '<ul>';
    $userData .= '<li>First Name: ' . $_SESSION['clientData']['clientFirstname'] . '</li>';
    $userData .= '<li>Last Name: ' . $_SESSION['clientData']['clientLastname'] . '</li>';
    $userData .= '<li>Email: ' . $_SESSION['clientData']['clientEmail'] . '</li>';
//        $userData .= '<li>Level: ' . $_SESSION['clientData']['clientLevel'] . '</li>';
    $userData .= '</ul>';
    $userData .= '<p><a href="/acme/accounts/?action=update">Update Account Information</a></p>';
    return $userData;
}

function productsLink() {
    $productsLink = '<h2>Administrative Functions</h2>';
    $productsLink .= '<p>Use the link below to manage products</p>';
    $productsLink .= '<p><a href="/acme/products/">Products Management</a></p>';
    return $productsLink;
}

//Function to build a display of products within an unordered list
function buildProductsDisplay($products){
    $pd = '<ul id="prod-display">';
    foreach ($products as $product) {
        $pd .= '<li>';
        $pd .= "<a href='/acme/products/?action=item&item=$product[invId]'><img src='$product[invThumbnail]' alt='Image of $product[invName] on Acme.com'></a>";
        $pd .= '<hr>';
        $pd .= "<h2><a href='/acme/products/?action=item&item=$product[invId]'>$product[invName]</a></h2>";
        $pd .= "<span>$$product[invPrice]</span>";
        $pd .= '</li>';
    }
    $pd .= '</ul>';
    return $pd;
}

//Function to build a display for a specific item
function buildItemDisplay($itemData) {
//    var_dump($itemData);
//    exit;
    $itemView = "<div class='flexContainer'><img src='$itemData[invImage]' alt='$itemData[invName]' />";
    $itemView .= "<div class='specs'><h1>$itemData[invName]</h1><hr>";
    $itemView .= "<h2>Price: $$itemData[invPrice]</h2>";
    $itemView .= "<p class='green'>Only $itemData[invStock] left in stock!</p>";
    $itemView .= "<p class='message'>Product reviews can be seen at the bottom of the page.</p>";
    $itemView .= "<ul>";
    $itemView .= "<li>Description: $itemData[invDescription]</li>";
    $itemView .= "<li>Size: $itemData[invSize] inches</li>";
    $itemView .= "<li>Weight: $itemData[invWeight] pounds</li>";
    $itemView .= "<li>Location: $itemData[invLocation]</li>";
    $itemView .= "<li>Vendor: $itemData[invVendor]</li>";
    $itemView .= "<li>Style: $itemData[invStyle]</li>";
    $itemView .= '</ul></div></div>';
    return $itemView;
}

/* * ********************************
* Functions for working with images
* ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image) {
 $i = strrpos($image, '.');
 $image_name = substr($image, 0, $i);
 $ext = substr($image, $i);
 $image = $image_name . '-tn' . $ext;
 return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
 $id = '<ul id="image-display" >';
 foreach ($imageArray as $image) {
  $id .= '<li>';
  $id .= "<img src='$image[imgPath]' title='$image[invName] image on Acme.com' alt='$image[invName] image on Acme.com'>";
  $id .= "<p><a href='/acme/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
  $id .= '</li>';
 }
 $id .= '</ul>';
 return $id;
}

// Build the products select list
function buildProductsSelect($products) {
 $prodList = '<select name="invId" id="invId">';
 $prodList .= "<option>Choose a Product</option>";
 foreach ($products as $product) {
  $prodList .= "<option value='$product[invId]'>$product[invName]</option>";
 }
 $prodList .= '</select>';
 return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
 // Gets the paths, full and local directory
 global $image_dir, $image_dir_path;
 if (isset($_FILES[$name])) {
  // Gets the actual file name
  $filename = $_FILES[$name]['name'];
  if (empty($filename)) {
   return;
  }
 // Get the file from the temp folder on the server
 $source = $_FILES[$name]['tmp_name'];
 // Sets the new path - images folder in this directory
 $target = $image_dir_path . '/' . $filename;
 // Moves the file to the target folder
 move_uploaded_file($source, $target);
 // Send file for further processing
 processImage($image_dir_path, $filename);
 // Sets the path for the image for Database storage
 $filepath = $image_dir . '/' . $filename;
 // Returns the path where the file is stored
 return $filepath;
 }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
 // Set up the variables
 $dir = $dir . '/';

 // Set up the image path
 $image_path = $dir . $filename;

 // Set up the thumbnail image path
 $image_path_tn = $dir.makeThumbnailName($filename);

 // Create a thumbnail image that's a maximum of 200 pixels square
 resizeImage($image_path, $image_path_tn, 200, 200);

 // Resize original to a maximum of 500 pixels square
 resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {

 // Get image type
 $image_info = getimagesize($old_image_path);
 $image_type = $image_info[2];

 // Set up the function names
 switch ($image_type) {
 case IMAGETYPE_JPEG:
  $image_from_file = 'imagecreatefromjpeg';
  $image_to_file = 'imagejpeg';
 break;
 case IMAGETYPE_GIF:
  $image_from_file = 'imagecreatefromgif';
  $image_to_file = 'imagegif';
 break;
 case IMAGETYPE_PNG:
  $image_from_file = 'imagecreatefrompng';
  $image_to_file = 'imagepng';
 break;
 default:
  return;
 }

 // Get the old image and its height and width
 $old_image = $image_from_file($old_image_path);
 $old_width = imagesx($old_image);
 $old_height = imagesy($old_image);

 // Calculate height and width ratios
 $width_ratio = $old_width / $max_width;
 $height_ratio = $old_height / $max_height;

 // If image is larger than specified ratio, create the new image
 if ($width_ratio > 1 || $height_ratio > 1) {

  // Calculate height and width for the new image
  $ratio = max($width_ratio, $height_ratio);
  $new_height = round($old_height / $ratio);
  $new_width = round($old_width / $ratio);

  // Create the new image
  $new_image = imagecreatetruecolor($new_width, $new_height);

  // Set transparency according to image type
  if ($image_type == IMAGETYPE_GIF) {
   $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
   imagecolortransparent($new_image, $alpha);
  }

  if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
   imagealphablending($new_image, false);
   imagesavealpha($new_image, true);
  }

  // Copy old image to new image - this resizes the image
  $new_x = 0;
  $new_y = 0;
  $old_x = 0;
  $old_y = 0;
  imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

  // Write the new image to a new file
  $image_to_file($new_image, $new_image_path);
  // Free any memory associated with the new image
  imagedestroy($new_image);
  } else {
  // Write the old image to a new file
  $image_to_file($old_image, $new_image_path);
  }
  // Free any memory associated with the old image
  imagedestroy($old_image);
}

//Function to build the thumbnail images display
function buildThumbnailDisplay($thumbnailData) {
    $thumbnails = '<hr><h3>Product Thumbnails:</h3>';
    $thumbnails .= '<div class="flexContainer">';
    foreach ($thumbnailData as $thumbnail){
        $thumbnails .= "<img class='boarder' src='$thumbnail[imgPath]' alt='Thumbnail image of $thumbnail[invName]' />";
    }
    $thumbnails .= '</div>';
    return $thumbnails;
}

function buildReviewsDisplay($itemReviews) {
    $reviews = '<br/><div class="reviews"><br/>';
    foreach ($itemReviews as $review) {
        $screenName = substr($review['clientFirstname'],0,1);
        $screenName .= $review['clientLastname'];
        $date = date("j F, Y",strtotime($review['reviewDate']));
        $reviews .= '<p class="reviewP1"><b>' . $screenName . '</b> wrote on ' . $date;
        $reviews .= '<p class="reviewP2">' . $review['reviewText'] . '</p>';
    }
    $reviews .= '<br/></div>';
    return $reviews;
}

//Function to build the client reviews for the admin view
function buildClientReviews() {
    $clientId = $_SESSION['clientData']['clientId'];
    $reviews = getClientReviews($clientId);
    $rd = '<hr><h2>Manage Your Product Reviews:</h2><ul>';
    foreach ($reviews as $review) {
        $date = date("j F, Y",strtotime($review['reviewDate']));
        $rd .= "<li><b>$review[invName]</b> (reviewed on $date): "
                . "<a href='../reviews/index.php?action=editReview&reviewId=$review[reviewId]'>Edit</a> | "
                . "<a href='../reviews/index.php?action=confirmDeletion&reviewId=$review[reviewId]'>Delete</a>";
    }
    $rd .= '</ul>';
    return $rd;
}