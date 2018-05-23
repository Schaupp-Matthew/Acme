<?php

/* 
 * Products model
 */

//function to add a new category to database
function newCat($categoryName) {
    //create a connection object using the acme connection function
    $db = acmeConnect();
    //sql statement
    $sql = 'INSERT INTO categories (categoryName) '
            . 'VALUES (:categoryName)';
    //create prepared statement with acme connection
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
    
    //insert the data
    $stmt->execute();
    //rows changed?
    $rowChanged = $stmt->rowCount();
    //close db interaction
    $stmt->closeCursor();
    //return success (rows changed)
    return $rowChanged;
}

//function to add a new product to database
function newProduct($categoryId, $invName, $invDescription, $invImage, $invThumbnail, $invPrice, 
                                $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle) {
    //create a connection object using the acme connection function
    $db = acmeConnect();
    //sql statement
    $sql = 'INSERT INTO inventory (invName, invDescription, invImage, invThumbnail,'
            . 'invPrice, invStock, invSize, invWeight, invLocation, categoryId, invVendor, invStyle) '
            . 'VALUES (:invName, :invDescription, :invImage, :invThumbnail,'
            . ':invPrice, :invStock, :invSize, :invWeight, :invLocation, :categoryId, :invVendor, :invStyle)';
    //create prepared statement with acme connection
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
    $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_INT);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invSize', $invSize, PDO::PARAM_INT);
    $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_INT);
    $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
    $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
    $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
    //insert the data
    $stmt->execute();
    //rows changed?
    $rowChanged = $stmt->rowCount();
    //close db interaction
    $stmt->closeCursor();
    //return success (rows changed)
    return $rowChanged;
}

//Function for getting basic product information from the inventory table for update or delete
function getProductBasics() {
    $db = acmeConnect();
    $sql = 'SELECT invName, invId FROM inventory ORDER BY invName ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

//Function for getting single product based on id
function getProductInfo($invId) {
    $db = acmeConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
}

//function to update a product in the database
function updateProduct($categoryId, $invId, $invName, $invDescription, $invImage, $invThumbnail, $invPrice, 
                                $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle) {
    
    //create a connection object using the acme connection function
    $db = acmeConnect();
    //sql statement
    $sql = 'UPDATE inventory '
            . 'SET categoryId = :categoryId, '
            . 'invName = :invName, '
            . 'invDescription = :invDescription, '
            . 'invImage = :invImage, '
            . 'invThumbnail = :invThumbnail, '
            . 'invPrice = :invPrice, '
            . 'invStock = :invStock, '
            . 'invSize = :invSize, '
            . 'invWeight = :invWeight, '
            . 'invLocation = :invLocation, '
            . 'invVendor = :invVendor, '
            . 'invStyle = :invStyle '
            . 'WHERE invId = :invId';
    //create prepared statement with acme connection
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
    $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_INT);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invSize', $invSize, PDO::PARAM_INT);
    $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_INT);
    $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
    $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
    $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    //insert the data
    $stmt->execute();
    //rows changed?
    $rowChanged = $stmt->rowCount();
    //close db interaction
    $stmt->closeCursor();
    //return success (rows changed)
    return $rowChanged;
}

//function to delete a product in the database
function deleteProduct($invId) {
    
    //create a connection object using the acme connection function
    $db = acmeConnect();
    //sql statement
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    //create prepared statement with acme connection
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    //insert the data
    $stmt->execute();
    //rows changed?
    $rowChanged = $stmt->rowCount();
    //close db interaction
    $stmt->closeCursor();
    //return success (rows changed)
    return $rowChanged;
}

//Function to get a list of products based on the category
function getProductsByCategory($type) {
    $db = acmeConnect();
    $sql = 'SELECT * FROM inventory WHERE categoryId IN (SELECT categoryId FROM categories WHERE categoryName = :catType)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':catType', $type, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

//Function to get data about a specific inventory item
function getItemData($invId) {
    $db = acmeConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $item;
}