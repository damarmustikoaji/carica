<?php
require_once('../connection.php');

$db = new DbConnection();
$connection = $db->getdbconnect();
$request_method=$_SERVER["REQUEST_METHOD"];
$request_token = keywordnya($_SERVER['HTTP_TOKEN']);

//=========================================

    switch($request_method) {
        case 'DELETE':
            if ($request_token == 1) {
                if(!empty($_GET["id"])) {
                    $id=$_GET["id"];
                    kebutuhan_hapus($id);
                }
                else {
                    default_response();
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

    function kebutuhan_hapus($id) {
        global $connection;
                $query="UPDATE kebutuhan SET deleted_at = '".date("Y-m-d H:m:s")."' WHERE id = '".$id."' and deleted_at IS NULL";
                if(mysqli_query($connection, $query)) {
                        $response=array(
                        'status' => "00",
                        'message' =>'Deleted Successfully.'
                        );
                        $statusCode="HTTP/1.0 200 OK";
                }
                else {
                    $response=array(
                    'status' => "99",
                    'message' =>'Delete Failed.'
                    );
                    $statusCode="HTTP/1.0 400 Bad Request";
                }
        header($statusCode);
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

function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

?>