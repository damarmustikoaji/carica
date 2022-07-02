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
                upload_file();
            }
            else {
                unauthorized_response();
            }
            break;
        default:
            default_response();
            break;
    }

    function upload_file() {
        global $connection;
        $data = json_decode(file_get_contents("php://input"), true);
        $fileName  =  $_FILES['sendimage']['name'];
        $tempPath  =  $_FILES['sendimage']['tmp_name'];
        $fileSize  =  $_FILES['sendimage']['size'];
        $catatan  =  $_POST['catatan'];
        $nominal  =  intval($_POST['nominal']);
        if ($fileName == "" || $tempPath == "" || $fileSize == "" || $catatan == "" || $nominal == "") {
            $response=array(
                'status' => "99",
                'pesan' =>'Required Field.'
                );
                $statusCode="HTTP/1.0 400 Bad Request";
        } else {
                // $response=array(
                // 'status' => "00",
                // 'message' =>'Success.',
                // 'file_name' => $fileName,
                // 'path' => $tempPath,
                // 'size' => $fileSize
                // );
                $upload_path = '../bukti/'; // set upload folder path 
	
                $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
                    
                // valid image extensions
                $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'heic'); 
                                
                // allow valid image file formats
                if(in_array($fileExt, $valid_extensions))
                {				
                    //check file not exist our upload folder path
                    if(!file_exists($upload_path . $fileName))
                    {
                        // check file size '5MB' 10mb
                        if($fileSize < 50000000){
                            $temp = explode(".", $fileName);
                            $newfilename = round(microtime(true)) . '.' . end($temp);
                            if($fileExt == 'heic') {
                                $newExtension = 'png';
                                $info = pathinfo($newfilename);
                                $newfilename = $info['dirname']."/".$info['filename'].'.'.$newExtension;
                            }
                            move_uploaded_file($tempPath, $upload_path . $newfilename); // move file from system temporary path to our upload folder path 
                            $query = mysqli_query($connection,'INSERT into pengeluaran (name, catatan, nominal) VALUES("'.$newfilename.'", "'.$catatan.'", '.$nominal.')');
                            $statusCode="HTTP/1.0 201 Created";
                            $response = array("pesan" => "Image Uploaded Successfully", "status" => "00", "fileName" => $fileName, "newfilename" => $newfilename, "tempPath" => $tempPath, "fileSize" => $fileSize, "upload_path" => $upload_path );
                        }
                        else{		
                            $statusCode="HTTP/1.0 422 Unprocessable Entity";
                            $response = array("pesan" => "Sorry, your file is too large, please upload 5 MB size", "status" => "99", "fileName" => $fileName, "tempPath" => $tempPath, "fileSize" => $fileSize, "upload_path" => $upload_path );
                        }
                    }
                    else
                    {	
                        $statusCode="HTTP/1.0 422 Unprocessable Entity";	
                        $response = array("pesan" => "Sorry, file already exists check upload folder", "status" => "99");
                    }
                }
                else
                {	
                    $statusCode="HTTP/1.0 422 Unprocessable Entity";	
                    $response = array("pesan" => "Sorry, only JPG, JPEG, PNG & GIF & HEIC files are allowed", "status" => "99");	
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