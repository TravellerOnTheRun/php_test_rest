<?php
require_once '../../util/helperFn.php';
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;

//Initialize route
$initArray = initializePostRoute('POST', 'user');
$user = $initArray[0];
$data = $initArray[1];

$user->email = $data->email;
$email_exists = $user->emailExists();

if ($email_exists && password_verify($data->password, $user->password)) {
    $secret_key = "itissofuckingsecret";
    $issuer_claim = $_SERVER['SERVER_NAME']; 
    $audience_claim = "THE_AUDIENCE";
    $issuedat_claim = time(); 
    $notbefore_claim = $issuedat_claim + 10;
    $expire_claim = $issuedat_claim + 3600; 
    $token = array(
        "iss" => $issuer_claim,
        "aud" => $audience_claim,
        "iat" => $issuedat_claim,
        "nbf" => $notbefore_claim,
        "exp" => $expire_claim,
        "data" => array(
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email
        )
    );

    $jwt = JWT::encode($token, $secret_key);
    echo json_encode(
        array(
            "message" => "Successful login.",
            "jwt" => $jwt,
            "name" => $user->name,
            "expireAt" => $expire_claim,
            "id" => $user->id
        )
    );
} else {
    if(!$email_exists) {
        http_response_code(404);
        echo json_encode(array('message' => "Email doesn't exist"));
    };

    http_response_code(401);
    echo json_encode(array("message" => "Login failed."));
}
