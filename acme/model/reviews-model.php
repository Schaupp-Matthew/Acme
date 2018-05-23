<?php

/* 
 * Reviews Model
 */

function insertReview($reviewText, $invId, $clientId) {
    //create a connection object using the acme connection function
    $db = acmeConnect();
    //sql statement
    $sql = 'INSERT INTO reviews (reviewText, invId, clientId) '
            . 'VALUES (:reviewText, :invId, :clientId)';
    //create prepared statement with acme connection
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
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

function getItemReviews($invId) {
    $db = acmeConnect();
    $sql = 'SELECT reviewText, reviewDate, clientFirstname, clientLastname '
            . 'FROM reviews JOIN clients ON reviews.clientId = clients.clientId '
            . 'WHERE invId = :invId ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;
}

function getClientReviews($clientId) {
    $db = acmeConnect();
    $sql = 'SELECT invName, reviewId, reviewDate '
            . 'FROM reviews JOIN inventory ON reviews.invId = inventory.invId '
            . 'WHERE clientId = :clientId ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;
}

function specificReview($reviewId) {
    $db = acmeConnect();
    $sql = 'SELECT * '
            . 'FROM reviews '
            . 'WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $review;
}

function updateReview($reviewId, $reviewText, $date) {
    //create a connection object using the acme connection function
    $db = acmeConnect();
    //sql statement
    $sql = 'UPDATE reviews '
            . 'SET reviewText = :reviewText, reviewDate = :date '
            . 'WHERE reviewId = :reviewId';
    //create prepared statement with acme connection
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':date', $date, PDO::PARAM_INT);
    //insert the data
    $stmt->execute();
    //rows changed?
    $rowChanged = $stmt->rowCount();
    //close db interaction
    $stmt->closeCursor();
    //return success (rows changed)
    return $rowChanged;
}

function deleteReview($reviewId) {
    //create a connection object using the acme connection function
    $db = acmeConnect();
    //sql statement
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    //create prepared statement with acme connection
    $stmt = $db->prepare($sql);
    //replace placeholders in sql statement with actual values and data types
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    //insert the data
    $stmt->execute();
    //rows changed?
    $rowChanged = $stmt->rowCount();
    //close db interaction
    $stmt->closeCursor();
    //return success (rows changed)
    return $rowChanged;
}