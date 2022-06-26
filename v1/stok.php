<?php
require_once('../connection.php');

$db = new DbConnection();
$connection = $db->getdbconnect();
$request_method=$_SERVER["REQUEST_METHOD"];
$request_token = keywordnya($_SERVER['HTTP_TOKEN']);

//=========================================

    switch($request_method) {
        case 'POST':
            if ($request_token == 1) {
                if(!empty($_GET["id"])) {
                    $id=$_GET["id"];
                    kebutuhan_gunakan($id);
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

    function kebutuhan_gunakan($id) {
        global $connection;
        $data = json_decode(file_get_contents('php://input'), true);
        $kebutuhan_stok=$data["balance_akhir"];
        $kebutuhan_pakai=$data["jumlah"];
        $kebutuhan_tipe=$data["tipe"];
        $cek_kebutuhan = [];
        $query="SELECT jumlah FROM kebutuhan WHERE id='".$id."'";
        $result=mysqli_query($connection, $query);
        while($row=mysqli_fetch_object($result))
        {
           $cek_kebutuhan[] =$row;
        }
        if($cek_kebutuhan){
            $cek_kebutuhan_status = true;
        }
        else {
            $cek_kebutuhan_status = false;
            $response=array(
                'status' => "99",
                'pesan' =>'Pakai Failed.'
                );
                $statusCode="HTTP/1.0 400 Bad Request";
        }
        if ($cek_kebutuhan_status){

            if ($kebutuhan_stok == "" || $kebutuhan_pakai == "") {
                $response=array(
                    'status' => "99",
                    'pesan' =>'Required Field.'
                    );
                    $statusCode="HTTP/1.0 400 Bad Request";
            } else {
                    if($kebutuhan_tipe == 'digunakan'){
                        $update_stok = $kebutuhan_stok - $kebutuhan_pakai;
                        $query="UPDATE kebutuhan SET jumlah=".$update_stok." WHERE id='".$id."'";
                    }
                    if($kebutuhan_tipe == 'restok'){
                        $update_stok = $kebutuhan_stok + $kebutuhan_pakai;
                        $query="UPDATE kebutuhan SET jumlah=".$update_stok." WHERE id='".$id."'";
                        }
                    if ($kebutuhan_stok <= 0 && $kebutuhan_tipe == 'digunakan') {
                        $response=array(
                            'status' => "99",
                            'pesan' =>'Stok Not Available.'
                            );
                            $statusCode="HTTP/1.0 200 OK";
                    } else {
                    if(mysqli_query($connection, $query)) {
                        $riwayat="INSERT INTO riwayat SET id='".gen_uuid()."', id_kebutuhan='".$id."', jumlah='".$kebutuhan_pakai."', balance_akhir='".$update_stok."', tipe='".$kebutuhan_tipe."'";
                        if(mysqli_query($connection, $riwayat)) {
                            $response=array(
                            'status' => "00",
                            'pesan' =>'Update Stok Successfully.'
                            );
                            $statusCode="HTTP/1.0 200 OK";
                        }
                    }
                    else {
                        $response=array(
                        'status' => "99",
                        'pesan' =>'Pakai Failed.'
                        );
                        $statusCode="HTTP/1.0 400 Bad Request";
                    }
            }
        }
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