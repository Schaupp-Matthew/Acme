<?php

/* 
 * Accounts model
 */



//Function for site registration
function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword){
    //create a connection object using the acme connection function
    $db = acmeConnect();
    //sql statement
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname,'
            . 'clientEmail, clientPassword) VALUES (:clientFirstname,'
            . ':clientLastname, :clientEmail, :clientPassword)';
    //create prepared statement with acme connection
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    //insert the data
    $stmt->execute();
    //rows changed?
    $rowChanged = $stmt->rowCount();
    //close db interaction
    $stmt->closeCursor();
    //return success (rows changed)
    return $rowChanged;
}

//Function for checking for an existing email address
function checkEmail ($email) {
    //Connnect to the database
    $db = acmeConnect();
    //Prepare the sql statement
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
    //Create the prepared statement
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    //Execute the statement
    $stmt->execute();
    //Fetch the result into a variable
    $emailMatched = $stmt->fetch(PDO::FETCH_NUM);
    //Close the explicit cursor
    $stmt->closeCursor();
    //Evaluate if a matching email was returned and return value to call point
    if(empty($emailMatched)) {
        return 0;  //If there is no match then return zero
        //echo 'Nothing found';
        //exit;
    }
    else {
        return 1;  //If there is a match then return a one
        //echo 'Match found';
        //exit;
        }
}

// Get client data based on an email address
function getClient($clientEmail){
      $db = acmeConnect();
      $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :email';
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
      $stmt->execute();
      $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt->closeCursor();
      return $clientData;
}

//Function for updating client info
function updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId) {
    //create a connection object using the acme connection function
    $db = acmeConnect();
    //sql statement
    $sql = 'UPDATE clients'
            . ' SET clientFirstname = :clientFirstname'
            . ', clientLastname = :clientLastname'
            . ', clientEmail = :clientEmail'
            . ' WHERE clientId = :clientId';
    //create prepared statement with acme connection
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    //insert the data
    $stmt->execute();
    //rows changed?
    $rowChanged = $stmt->rowCount();
    //close db interaction
    $stmt->closeCursor();
    //return success (rows changed)
    return $rowChanged;
}

//Function to get updated client data
function getUpdatedData($clientId) {
    $db = acmeConnect();
      $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel FROM clients WHERE clientId = :clientId';
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
      $stmt->execute();
      $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt->closeCursor();
      return $clientData;
}

//Function to update passwords
function updatePassword($hashdedPassword, $clientId) {
    //create a connection object using the acme connection function
    $db = acmeConnect();
    //sql statement
    $sql = 'UPDATE clients'
            . ' SET clientPassword = :clientPassword'
            . ' WHERE clientId = :clientId';
    //create prepared statement with acme connection
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':clientPassword', $hashdedPassword, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    //insert the data
    $stmt->execute();
    //rows changed?
    $rowChanged = $stmt->rowCount();
    //close db interaction
    $stmt->closeCursor();
    //return success (rows changed)
    return $rowChanged;
}