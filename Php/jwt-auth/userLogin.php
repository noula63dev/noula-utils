<?php
//ini_set("display_errors" , 1);
require "./vendor/autoload.php";
use \Firebase\JWT\JWT;

require_once('./configs/constants.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=utf-8");


include('./classes/mysqli2json.class.php');
if($_SERVER['REQUEST_METHOD']  === 'POST'){

    $json = json_decode(file_get_contents('php://input'));
    
    foreach ($json as $key => $value) {
        $posted[$key] = $value;
    }
    $sql ="SELECT * FROM users WHERE Email = '$posted[email]' ";

    $usersData = new Mysqli2Json('root', 'myl1nuxb0x','labdb', $sql);
    $usersData->selectData();
    if($usersData->getRows() > 0){
        $users = $usersData->getDatas();
        $id = $users['UserId'];
        $name = $users['NickName'];
        $email = $users['Email'];
        $admin = $users['Admin'];

        if($users["Password"] === $posted["password"]){

            $iat = $_SERVER['REQUEST_TIME'];

            $exp = $_SERVER['REQUEST_TIME'] + EXPIRATION_TIME;

            $user_data = array (
                "userid" => $id,
                "email" => $email,
                "name" => $name,
                "admin" => $admin
            );


            $payload = array(
                "iss" => "localhost",
                "aud" => "localhost",
                "iat" => $iat,
                "exp" => $exp,
                "data" => $user_data
            );


            $jwt = JWT::encode($payload, SECRET_KEY);

            $decoded = JWT::decode($jwt, SECRET_KEY , array(HASH));

            http_response_code(202);

            $result = array("jwt"=> $jwt ,"user" => $user_data , "status" => 1, "msg" => "User accepted");
        }
        else {
            http_response_code(401);

            $result = array("status" => 0, "msg" => "Unauthorized");
        }
    }
    else{
        http_response_code(404);

        $result = array("jwt"=> $jwt , "status" => 0, "msg" => "No user found");
        
    }
}
else{
    http_response_code(405);
    $result = array("status" => 0, "msg" => "Method not allowed");
}
echo json_encode($result);
?>