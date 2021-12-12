<?php
include_once './config/database.php';
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;

$query = "SELECT * FROM `users` WHERE `email` = '".$email."'";
$qry_exec = mysqli_query($con, $query);

$num = mysqli_num_rows($qry_exec);

if($num === 1){
    $row = mysqli_fetch_array($qry_exec);
    $id = $row['id'];
    $name = $row['name'];
    $email = $row['email'];
    $password2 = $row['password'];

    if($password === $password2){

        $secret_key = $jwt_secret;
        $issuer_claim = "THE_ISSUER"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 0; //not before in seconds
        $expire_claim = $issuedat_claim + 86400; // expire time 1 day in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $id,
                "name" => $name,
                "email" => $email
        ));


        $jwt = JWT::encode($token, $secret_key);
        echo json_encode(
            array(
                "message" => "Successful login.",
                "token" => $jwt,
                "userId" => $id,
                "email" => $email,
                "expireAt" => $expire_claim
            ));
    	} else {

            echo json_encode(array("message" => "Invalid username or password."));
        }
    } else {
        echo json_encode(array("message" => "Invalid username or password."));
    }
?>