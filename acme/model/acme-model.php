<?php

/* 
 *Acme model
 */

function getCategories() {
    //Create a connection object from the acme connection function
    $db = acmeConnect();
    //The SQL statement to be used with the database
    $sql = 'SELECT categoryName, categoryId FROM categories ORDER BY categoryName ASC';
    //Creates the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    //Runs the prepared statement
    $stmt->execute();
    //Gets the data from the database and 
    //stores it as an array in the $categories variable
    $categories = $stmt->fetchAll();
    //Closes the interaction with the database
    $stmt->closeCursor();
    //Sends the array of data back to the call point (controller)
    return $categories;
}

