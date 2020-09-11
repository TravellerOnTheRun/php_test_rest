<?php
require_once '../../util/helperFn.php';
require "../../vendor/autoload.php";

use \Firebase\JWT\JWT;

//Initialize route
$initArray = initializePostRoute('POST', 'comment');
$comment = $initArray[0];
$data = $initArray[1];

$secret_key = "itissofuckingsecret";
$jwt = null;
$queryString = $_SERVER['QUERY_STRING'];

$arr = explode('=', $queryString);

$jwt = $arr[1];

if ($jwt) {

  try {

    $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

    $comment->body = $data->body;
    $comment->post_id = $data->post_id;
    $comment->user_id = $data->user_id;
    $comment->username = $data->username;

    if ($comment->create()) {
      http_response_code(201);
      echo json_encode(
        array('message' => 'Comment posted!')
      );
    } else {
      http_response_code(500);
      echo json_encode(
        array('message' => 'Failed to post comment!')
      );
    }
  } catch (Exception $e) {

    http_response_code(401);

    echo json_encode(array(
      "message" => "Access denied.",
      "error" => $e->getMessage()
    ));
  }
}