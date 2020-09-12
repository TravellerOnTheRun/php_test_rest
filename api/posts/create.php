<?php
require_once '../../util/helperFn.php';
require "../../vendor/autoload.php";

use \Firebase\JWT\JWT;

//Initialize route
$initArray = initializePostRoute('POST', 'post');
$post = $initArray[0];
$data = $initArray[1];

$secret_key = "itissofuckingsecret";
$jwt = null;
$queryString = $_SERVER['QUERY_STRING'];

$arr = explode('=', $queryString);

$jwt = $arr[1];

if ($jwt) {

  try {

    $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $decoded->data->name;
    $post->user_id = $decoded->data->id;
    $post->description = $data->description;


    // Create post
    if ($post->create()) {
      http_response_code(201);
      echo json_encode(
        array('message' => 'Post Created')
      );
    } else {
      http_response_code(500);
      echo json_encode(
        array('message' => 'Failed to create post!')
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
