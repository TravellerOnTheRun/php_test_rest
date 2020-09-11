<?php
require_once '../../util/helperFn.php';

//Initialize route
$initArray = initializePostRoute('DELETE', 'post');
$post = $initArray[0];
$data = $initArray[1];

$post->id = $data->id;

  // Create user
  if($post->delete()) {
    http_response_code(200);
    echo json_encode(
      array('message' => 'Post Deleted')
    );
  } else {
    http_response_code(500);
    echo json_encode(
      array('message' => 'Failed to update post!')
    );
  }