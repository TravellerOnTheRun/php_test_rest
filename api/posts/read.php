<?php
require_once '../../util/helperFn.php';

$post = initializeGetRoute('post');

  // Blog post query
  $result = $post->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    $posts_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $post_item = array(
        'id' => $id,
        'title' => $title,
        'body' => html_entity_decode($body),
        'author' => $author,
        'user_id' => $user_id,
        'description' => $description
      );

      array_push($posts_arr, $post_item);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);

  } else {
    http_response_code(404);
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }