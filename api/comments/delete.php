<?php
require_once '../../util/helperFn.php';
require "../../vendor/autoload.php";

use \Firebase\JWT\JWT;

//Initialize route
$initArray = initializePostRoute('DELETE', 'comment');
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

    $comment->id = $data->id;
    $comment->user_id = $decoded->data->id;

    if ($comment->delete()) {
      http_response_code(201);
      echo json_encode(
        array('message' => 'Comment deleted!')
      );
    } else {
      http_response_code(500);
      echo json_encode(
        array('message' => 'Failed to delete comment!')
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