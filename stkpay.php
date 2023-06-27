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

    $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

    $headers = ['Content-Type:application/json; charset=utf8'];

    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    $CallBackURL = 'https://quick-horses-double.loca.lt/LNM-Push-Stk/callback_url.php';
    $Type_of_Transaction = 'CustomerPayBillOnline';
    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);


    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $results = json_decode($result);
    $access_token = $results->access_token;
    curl_close($curl);

    $curlTransfer = curl_init();
    curl_setopt($curlTransfer, CURLOPT_URL, $initiate_url);
    curl_setopt($curlTransfer, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token));

    $curlTransferPostData = [
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' =>$Timestamp,
        'TransactionType' =>$Type_of_Transaction,
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => 'Test001',
        'TransactionDesc' => 'test',
    ];

    $data2_string = json_encode($curlTransferPostData);


    curl_setopt($curlTransfer, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlTransfer, CURLOPT_POST, true);
    curl_setopt($curlTransfer, CURLOPT_POSTFIELDS, $data2_string);
    curl_setopt($curlTransfer, CURLOPT_HEADER, false);
    curl_setopt($curlTransfer, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlTransfer, CURLOPT_SSL_VERIFYHOST, 0);
    $curlTransferResponse = json_decode(curl_exec($curlTransfer));

    echo json_encode($curlTransferResponse, JSON_PRETTY_PRINT);

    header("Location:index.php");
}

