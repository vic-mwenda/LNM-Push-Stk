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

    $CallBackURL = 'https://small-planets-guess.loca.lt/LNM-Push-Stk/callback_url.php';
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
        'CallBackURL' => 'https://peternjeru.co.ke/safdaraja/api/confirmation.php',
        'AccountReference' => 'Test001',
        'TransactionDesc' => 'test',
    ];

    $data2_string = json_encode($curlTransferPostData);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data2_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response,true);

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

    $curl = curl_init('https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '. $access_token));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
        'ShortCode' => "600141",
        'ResponseType' => 'Completed',
        'ConfirmationURL' => "https://56b0-197-138-1-2.ngrok-free.app/LNM-Push-Stk/callback_url.php",
    )));
    $curl_response = curl_exec($curl);
    echo $curl_response;

    header("Location:index.php");


}    


