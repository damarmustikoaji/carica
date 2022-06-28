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
                if(!empty($_GET["page"])) {
                    $page=$_GET["page"];
                    get_kebutuhan_riwayat_page($page);
                }
                else {
                    get_kebutuhan_riwayat();
                    } 
            }
            else {
                unauthorized_response();
            }
            break;
        default:
            default_response();
            break;
    }

function get_kebutuhan_riwayat_page($page) {
    global $connection;
    $data = [];
    $limit = 10;
    $limitStart = ($page - 1) * $limit;
    $query="SELECT riwayat.id, kebutuhan.nama, riwayat.tipe, riwayat.jumlah, riwayat.balance_akhir, riwayat.created_at FROM riwayat INNER JOIN kebutuhan ON riwayat.id_kebutuhan=kebutuhan.id LIMIT ".$limitStart.",".$limit;
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_object($result))
    {
       $data[] =$row;
    }
    if($data){
    $response=array(
                   'status' => "00",
                   'pesan' =>'Success',
                   'data' => $data,
                   'limit' => $limit,
                   'halaman' => intval($page)
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

function get_kebutuhan_riwayat() {
    global $connection;
    $data = [];
    $query="SELECT riwayat.id, kebutuhan.nama, riwayat.tipe, riwayat.jumlah, riwayat.balance_akhir, riwayat.created_at FROM riwayat INNER JOIN kebutuhan ON riwayat.id_kebutuhan=kebutuhan.id ORDER BY riwayat.created_at DESC";
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
    $hai = md5($key);
    if($key != '') {
    $query="SELECT * FROM keyword WHERE secret='".$hai."' ";
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