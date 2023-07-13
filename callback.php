<?php
include 'includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $callbackData = json_decode(file_get_contents('php://input'), true);

    try {
        $sql = "INSERT INTO callback_data (MerchantRequestID, CheckoutRequestID, ResultCode, ResultDesc, Amount, MpesaReceiptNumber, TransactionDate, PhoneNumber)
                VALUES (
                    '{$callbackData['Body']['stkCallback']['MerchantRequestID']}',
                    '{$callbackData['Body']['stkCallback']['CheckoutRequestID']}',
                    {$callbackData['Body']['stkCallback']['ResultCode']},
                    '{$callbackData['Body']['stkCallback']['ResultDesc']}',
                    {$callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value']},
                    '{$callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value']}',
                    '{$callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][2]['Value']}',
                    '{$callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value']}'
                )";
        
        if ($conn->query($sql)) {
            http_response_code(200);
            echo "Callback data inserted successfully into the database.";
        } else {
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        http_response_code(500); 
        echo "Error inserting callback data: " . $e->getMessage();
    }

    $conn->close();
    
} else {
    http_response_code(405); 
    echo "Invalid request method.";
}
