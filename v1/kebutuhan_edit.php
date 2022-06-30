<?php
require_once('../connection.php');

$db = new DbConnection();
$connection = $db->getdbconnect();
$request_method=$_SERVER["REQUEST_METHOD"];
$request_token = keywordnya($_SERVER['HTTP_TOKEN']);

//=========================================

    switch($request_method) {
        case 'PUT':
            if ($request_token == 1) {
                if(!empty($_GET["id"])) {
                    $id=$_GET["id"];
                    kebutuhan_edit($id);
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

    function kebutuhan_edit($id) {
        global $connection;
        $data = json_decode(file_get_contents('php://input'), true);
        $kebutuhan_nama=$data["nama"];
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
                'message' =>'Edit Failed.'
                );
                $statusCode="HTTP/1.0 400 Bad Request";
        }

        if ($kategori_cek){

        if ($kebutuhan_nama == "" || $kebutuhan_kategori == "") {
            $response=array(
                'status' => "99",
                'message' =>'Required Field.'
                );
                $statusCode="HTTP/1.0 400 Bad Request";
        } else {
            $query="UPDATE kebutuhan SET nama='".$kebutuhan_nama."', kategori='".$kebutuhan_kategori."', expired_at='".$kebutuhan_expired."' WHERE id='".$id."'";
            if(mysqli_query($connection, $query)) {
                $response=array(
                'status' => "00",
                'message' =>'Edited Successfully.'
                );
                $statusCode="HTTP/1.0 201 Created";
            }
            else {
                $response=array(
                'status' => "99",
                'message' =>'Edit Failed.'
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

?>