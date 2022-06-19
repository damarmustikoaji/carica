<?php
require_once('../connection.php');

$db = new DbConnection();
$connection = $db->getdbconnect();
$request_method=$_SERVER["REQUEST_METHOD"];
$request_token = keywordnya($_SERVER['HTTP_TOKEN']);

//=========================================

    switch($request_method) {
        case 'GET':
            if ($request_token == 1) {
                if(!empty($_GET["id"])) {
                    $id=$_GET["id"];
                    get_kebutuhan_detail($id);
                }
                else {
                    get_kebutuhan_list();
                    } 
            }
            else {
                unauthorized_response();
            }
            header('Content-Type: application/json');
            break;
        default:
            default_response();
            header('Content-Type: application/json');
            break;
    }

function get_kebutuhan_detail($id) {
    global $connection;
    $data = [];
    $query="SELECT * FROM kebutuhan";
    if($id != '') {
        $query.=" WHERE id='".$id."' LIMIT 1";
    }
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_object($result))
    {
       $data[] =$row;
    }
    if($data){
    $response=array(
                   'status' => "00",
                   'message' =>'Success',
                   'data' => $data
                );
              }
    else {
      $response=array(
          'status' => "99",
          'message' =>'There is no data',
          'data' => null
       );  
    }
    header("HTTP/1.0 200 OK");
    echo json_encode($response);
}

function get_kebutuhan_list() {
    global $connection;
    $data = [];
    $query="SELECT * FROM kebutuhan";
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_object($result))
    {
       $data[] =$row;
    }
    if($data){
    $response=array(
                   'status' => "00",
                   'pesan' =>'Success',
                   'data' => $data
                );
              }
    else {
      $response=array(
          'status' => "99",
          'pesan' =>'There is no data',
          'data' => null
       );  
    }
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

function unauthorized_response() {
    $response=array(
       'status' => "99",
       'pesan' =>'Unauthorized'
    );
    echo json_encode($response);
    header("HTTP/1.0 401 Unauthorized");
}

function keywordnya($key) {
    global $connection;
    $keynya = [];
    if($key != '') {
    $query="SELECT * FROM keyword WHERE value='".$key."' ";
    }
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_object($result))
    {
       $keynya[] =$row;
    }
    if($keynya){
        return true;
    }
    else {
        return false;
    }
}

?>