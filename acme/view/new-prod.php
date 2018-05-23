<?php
//Build a dynamic drop-down select list using the $categories array
$catList = '<select name="categoryId" id="categoryId">';
foreach ($categories as $nameId) {
    $catList .= "<option value='$nameId[categoryId]'";
      if(isset($categoryId)) {
          if($nameId['categoryId'] === $categoryId) {
              $catList .= ' selected ';
          }
      }
    $catList .= ">$nameId[categoryName]</option>";
}
$catList .= '</select>';

if($_SESSION['clientData']['clientLevel'] < 2){
    header('Location: /acme/index.php');
}
?>
<!DOCTYPE html>

<!--/* 
 * New Product View
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
                 <h1>Add Product</h1>
                 <hr>
             </header>
             
             <!--Add Content Here -->
             <p>Add a new product below.  All fields are required!</p>
             
             <!-- success/error message code block -->
             <?php if (isset($message)) {echo $message;} ?>
             
             <form method="post" action="/acme/products/index.php">
                 <fieldset>
                     <legend>Product Information:</legend>
                     <br>
                     <label for="categoryId">Category</label><br>
                     <?php echo $catList; ?>
                     <br><br>
                     <label for="invName">Product Name</label><br>
                     <input class="Input" type="text" id="invName" name="invName" <?php if(isset($invName)){echo "value='$invName'";} ?> required>
                     <br><br>
                     <label for="invDescription">Product Description</label><br>
                     <textarea rows="10" cols="25" class="Input" id="invDescription" name="invDescription" required><?php if(isset($invDescription)){echo $invDescription;} ?></textarea>
                     <br><br>
                     <label for="invImage">Product Image</label><br>
                     <input class="Input" type="text" id="invImage" name="invImage" value="/acme/images/products/no-image.png" <?php if(isset($invImage)){echo "value='$invImage'";} ?> required>
                     <br><br>
                     <label for="invThumbnail">Product Thumbnail</label><br>
                     <input class="Input" type="text" id="invThumbnail" name="invThumbnail" value="/acme/images/products/no-image.png" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";} ?> required>
                     <br><br>
                     <label for="invPrice">Product Price</label><br>
                     <span class="inputNote">**Required Format Example: 9.00**</span><br>
                     <input class="Input" type="text" id="invPrice" name="invPrice" pattern="(\d+\.\d{2})" <?php if(isset($invPrice)){echo "value='$invPrice'";} ?> required>
                     <br><br>
                     <label for="invStock">Product Stock</label><br>
                     <input class="Input" type="number" id="invStock" name="invStock" <?php if(isset($invStock)){echo "value='$invStock'";} ?> required>
                     <br><br>
                     <label for="invSize">Product Size</label><br>
                     <input class="Input" type="text" id="invSize" name="invSize" <?php if(isset($invSize)){echo "value='$invSize'";} ?> required>
                     <br><br>
                     <label for="invWeight">Product Weight</label><br>
                     <input class="Input" type="text" id="invWeight" name="invWeight" <?php if(isset($invWeight)){echo "value='$invWeight'";} ?> required>
                     <br><br>
                     <label for="invLocation">Product Location</label><br>
                     <input class="Input" type="text" id="invLocation" name="invLocation" <?php if(isset($invLocation)){echo "value='$invLocation'";} ?> required>
                     <br><br>
                     <label for="invVendor">Product Vendor</label><br>
                     <input class="Input" type="text" id="invVendor" name="invVendor" <?php if(isset($invVendor)){echo "value='$invVendor'";} ?> required>
                     <br><br>
                     <label for="invStyle">Product Style</label><br>
                     <input class="Input" type="text" id="invStyle" name="invStyle" <?php if(isset($invStyle)){echo "value='$invStyle'";} ?> required>
                     <br><br>
                     <input type="submit" name="submit" class="" value="Add New Product">
                     <!-- Add action name - value pair -->
                     <input type="hidden" name="action" value="newProd" >
                 </fieldset>
             </form>
         
         </main>    
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>



