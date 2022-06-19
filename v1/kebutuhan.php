<?php
// Connect to database
require_once('../connection.php');

$db = new DbConnection();
$connection = $db->getdbconnect();
$request_method=$_SERVER["REQUEST_METHOD"];
//=========================================

switch($request_method) {
    case 'GET':
        if(!empty($_GET["id"])) {
            $id=$_GET["id"];
            get_kebutuhan_detail($id);
        }
        else {
            get_kebutuhan_list();
        }
        header('Content-Type: application/json');
        break;
    default:
    // Invalid Request Method
        default_response();
        header('Content-Type: application/json');
        header("HTTP/1.0 501 Not Implemented");
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
       'pesan' =>'Error'
    );
    echo json_encode($response);
}

?>