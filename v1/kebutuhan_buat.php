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
                get_kebutuhan_buat();
            }
            else {
                unauthorized_response();
            }
            break;
        default:
            default_response();
            break;
    }

    function get_kebutuhan_buat() {
        global $connection;
        $data = json_decode(file_get_contents('php://input'), true);
        $kebutuhan_id = gen_uuid();
        $kebutuhan_nama=$data["nama"];
        $kebutuhan_jumlah=$data["jumlah"];
        $kebutuhan_kategori=$data["kategori"];
        $kebutuhan_expired=$data["expired"];
        $kategori = [];
        $query="SELECT * FROM kategori WHERE nama='".$kebutuhan_kategori."' LIMIT 1";
        $result=mysqli_query($connection, $query);
        while($row=mysqli_fetch_object($result))
        {
           $kategori[] =$row;
        }
        if($kategori){
            $kategori_cek = true;
        }
        else {
            $kategori_cek = false;
            $response=array(
                'status' => "99",
                'message' =>'Add Failed.'
                );
                $statusCode="HTTP/1.0 400 Bad Request";
        }

        if ($kategori_cek){

        if ($kebutuhan_nama == "" || $kebutuhan_jumlah == "" || $kebutuhan_kategori == "") {
            if($kebutuhan_expired == ""){
                $kebutuhan_expired = NULL;
            }
            $response=array(
                'status' => "99",
                'message' =>'Required Field.'
                );
                $statusCode="HTTP/1.0 400 Bad Request";
        } else {
            $query="INSERT INTO kebutuhan SET id='".$kebutuhan_id."', nama='".$kebutuhan_nama."', jumlah='".$kebutuhan_jumlah."', kategori='".$kebutuhan_kategori."', expired_at='".$kebutuhan_expired."'";
            if(mysqli_query($connection, $query)) {
                $riwayat="INSERT INTO riwayat SET id='".gen_uuid()."', id_kebutuhan='".$kebutuhan_id."', jumlah='".$kebutuhan_jumlah."', balance_akhir=0, tipe='restok'";
                if(mysqli_query($connection, $riwayat)) {
                    $response=array(
                    'status' => "00",
                    'message' =>'Added Successfully.'
                    );
                    $statusCode="HTTP/1.0 201 Created";
             }
            }
            else {
                $response=array(
                'status' => "99",
                'message' =>'Add Failed.'
                );
                $statusCode="HTTP/1.0 400 Bad Request";
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