<?php
$request_method=$_SERVER["REQUEST_METHOD"];
//=========================================

switch($request_method) {
    case 'GET':
        // Update Product
        check_health();
        break;
    default:
    // Invalid Request Method
        default_response();
        break;
}

function check_health() {
    $response=array(
        'status' => "00",
        'message' =>'Check Health OK.'
    );
    header('Content-Type: application/json');
    header("HTTP/1.0 200 OK");
    echo json_encode($response);
    }

function default_response() {
    $response=array(
       'status' => "99",
       'pesan' =>'Not Found'
    );
    echo json_encode($response);
    header('Content-Type: application/json');
    header("HTTP/1.0 404 Not Found");
}
?>