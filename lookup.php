<?php
include "includes/connection.php";

$trans_id = $_POST['trans_id'];

$response = array();

try {
    $sql = "SELECT * FROM mpesa_transaction WHERE TransID = :trans_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':trans_id', $trans_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $response['title'] = 'Transaction Found';
        $response['message'] = 'The transaction exists in the database.';
        $response['type'] = 'success';
    } else {
        $response['title'] = 'Transaction Not Found';
        $response['message'] = 'The transaction does not exist in the database.';
        $response['type'] = 'error';
    }
} catch (PDOException $e) {
    $response['title'] = 'Error';
    $response['message'] = 'Database query failed: ' . $e->getMessage();
    $response['type'] = 'error';
}

echo json_encode($response);
