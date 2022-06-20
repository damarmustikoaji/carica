<?php

$request_method=$_SERVER["REQUEST_METHOD"];
//=========================================

switch($request_method) {
    default:
    // Invalid Request Method
    defaultresponse();
    header("HTTP/1.0 200 OK");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
    break;
}

function defaultresponse() {
    $response=array(
            "status" => "99",
            "message" => "route not found ya"
    );  
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>