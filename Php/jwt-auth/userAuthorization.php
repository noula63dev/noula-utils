<?php
require "./vendor/autoload.php";
use \Firebase\JWT\JWT;

require_once('./configs/constants.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//$secret_key = "00nondiregattosenoncelhainelsacco00";

if($_SERVER['REQUEST_METHOD']  === 'POST'){
    
    $headers = apache_request_headers();
    if(!empty($headers[authorization])){
        echo $jwt = $headers[authorization];
    }
    if(!empty($headers[Authorization])){
        echo $jwt = $headers[Authorization];
    }

    if(!empty($jwt)){
        try {
            
            http_response_code(200);
            
            $decoded = JWT::decode($jwt,SECRET_KEY,array(HASH));
            
            $result = array("status" => 1, "msg" => "User Authorized", "user" => $decoded);

        } catch (Exception  $e) {
            
            http_response_code(400);
            
            $result = array("status" => 0, "msg" =>  $e->getMessage());
        }
        
    }
    
}
else{
  
    http_response_code(400); 
  
    $result = array("status" => 0, "msg" => "Bad Request");

}
echo json_encode($result);
?>