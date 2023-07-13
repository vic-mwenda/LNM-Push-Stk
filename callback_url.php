<?php
include 'includes/connection.php';

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Allow-Headers: Content-Type");

$jsonData = file_get_contents('php://input');

if(empty($jsonData)) {
    http_response_code(400);
    echo "Error: No data provided.";
    exit;
}

$data = json_decode($jsonData, true);

try {

    $stmt = $conn->prepare("INSERT INTO mpesa_transaction (TransactionType, TransID, TransTime, TransAmount, BusinessShortCode, BillRefNumber, InvoiceNumber, OrgAccountBalance, ThirdPartyTransID, MSISDN, FirstName, MiddleName, LastName) 
                            VALUES (:TransactionType, :TransID, :TransTime, :TransAmount, :BusinessShortCode, :BillRefNumber, :InvoiceNumber, :OrgAccountBalance, :ThirdPartyTransID, :MSISDN, :FirstName, :MiddleName, :LastName)");

    $stmt->bindParam(':TransactionType', $data['TransactionType']);
    $stmt->bindParam(':TransID', $data['TransID']);
    $stmt->bindParam(':TransTime', $data['TransTime']);
    $stmt->bindParam(':TransAmount', $data['TransAmount']);
    $stmt->bindParam(':BusinessShortCode', $data['BusinessShortCode']);
    $stmt->bindParam(':BillRefNumber', $data['BillRefNumber']);
    $stmt->bindParam(':InvoiceNumber', $data['InvoiceNumber']);
    $stmt->bindParam(':OrgAccountBalance', $data['OrgAccountBalance']);
    $stmt->bindParam(':ThirdPartyTransID', $data['ThirdPartyTransID']);
    $stmt->bindParam(':MSISDN', $data['MSISDN']);
    $stmt->bindParam(':FirstName', $data['FirstName']);
    $stmt->bindParam(':MiddleName', $data['MiddleName']);
    $stmt->bindParam(':LastName', $data['LastName']);
    $stmt->execute();

    http_response_code(200);
    echo "Data inserted successfully.";
    
} catch(PDOException $e) {
    http_response_code(500);
    echo "Error inserting data: " . $e->getMessage();
}

$conn = null;
