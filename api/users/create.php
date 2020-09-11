<?php
require_once '../../util/helperFn.php';
//Initialize route
$initArray = initializePostRoute('POST', 'user');
$user = $initArray[0];
$data = $initArray[1];

$user->name = $data->name;
$user->email = $data->email;
$user->password = password_hash($data->password, PASSWORD_DEFAULT);

  // Create user
  if($user->create()) {
    echo json_encode(
      array(
        'message' => 'User Created'
      )
    );
  } else {
    echo json_encode(
      array('message' => 'Failed to create user!')
    );
  }
