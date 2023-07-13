<?php

if (isset($_GET['phone'])) {

    date_default_timezone_set('Africa/Nairobi');

    $consumerKey = '4TEg1wBjOVwIUdXyQaQAmGJfeL30tjRr';
    $consumerSecret = 'loiEqKm6RSpL1xbS';

    $Amount = 1;
    $BusinessShortCode = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

    $PartyA = $_GET['phone'];
    $AccountReference = 'Test001';
    $TransactionDesc = 'test';

    $Timestamp = date('YmdHis');
    $dataToEncode = $BusinessShortCode . $Passkey . $Timestamp;
    $encodedData = base64_encode($dataToEncode);

    $Password =$encodedData;

    $Type_of_Transaction = 'CustomerPayBillOnline';
    $credentials = base64_encode("$consumerKey . ':' . $consumerSecret");

    // Obtain Access Token
    $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic NFRFZzF3QmpPVndJVWRYeVFhUUFtR0pmZUwzMHRqUnI6bG9pRXFLbTZSU3BMMXhiUw==']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);


    if ($response === false) {
        echo 'Error occurred during Access Token retrieval: ' . curl_error($ch);
        exit();
    }

    $results = json_decode($response,true);
    $access_token = $results["access_token"];
    
    $curlTransferInfo = curl_getinfo($ch);
    $httpCode = $curlTransferInfo['http_code'];

    if ($httpCode != 200) {
        echo 'Access Token Retrieval error. HTTP Code: ' . $httpCode;
        exit();
    }
        
    curl_close($ch);

    //Initiate STK Push Request

    $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token));
    curl_setopt($ch, CURLOPT_POST, 1);
    $curlTransferPostData = [
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => $Type_of_Transaction,
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => 'https://59fd-197-138-1-2.ngrok-free.app/LNM-Push-Stk/callback.php',
        'AccountReference' => 'Test001',
        'TransactionDesc' => 'test',
    ];

    $data2_string = json_encode($curlTransferPostData);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data2_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response,true);
    $CheckoutRequestID = $result['CheckoutRequestID'];

    if ($result === null) {
        echo "Failed to decode JSON response.";
    }

    $curlTransferInfo = curl_getinfo($ch);
    $httpCode = $curlTransferInfo['http_code'];

    if ($httpCode != 200) {
        echo 'STK Push initiation failed. HTTP Code: ' . $result['errorMessage'];
        exit();
    }

    $curlTransferResponseDecoded = json_decode($response);

    if ($curlTransferResponseDecoded === null) {
        echo 'Error occurred while decoding STK Push response.';
        exit();
    }

    echo json_encode($curlTransferResponseDecoded, JSON_PRETTY_PRINT);

    //Register Urls

    header("Location:confirmation.php");



}    

// $data = array(
//     'BusinessShortCode' => $BusinessShortCode,
//     'Password' => $Password,
//     'Timestamp' => $Timestamp,
//     'CheckoutRequestID' => $CheckoutRequestID
// );

// $data_string = json_encode($data);

// $access_token = 'YOUR_ACCESS_TOKEN'; // Replace with your actual access token

// $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';

// $totalSeconds = 30;
// $intervalSeconds = 10;
// $startTime = time();
// $endTime = $startTime + $totalSeconds;

// while (time() < $endTime) {
//     $ch = curl_init($url);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token));
//     curl_setopt($ch, CURLOPT_POST, 1);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     $response = curl_exec($ch);
//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

//     curl_close($ch);

//     if ($httpCode == 200) {
//         // Successful API call
//         echo $response;
//     } else {
//         // API call failed
//         echo 'Error: ' . $response;
//     }

//     sleep($intervalSeconds);
// }

// ?>


