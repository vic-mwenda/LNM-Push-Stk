<?php

function validation() {
    $context = array(
        "ResultCode" => 0,
        "ResultDesc" => "Accepted"
    );
    return json_encode($context);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = validation();
    header('Content-Type: application/json');
    echo $response;
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Invalid request method"));
}
?> 
