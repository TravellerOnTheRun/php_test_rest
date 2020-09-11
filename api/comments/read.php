<?php
require_once '../../util/helperFn.php';

$comment = initializeGetRoute('comment');

$comment->post_id = isset($_GET['postId']) ? $_GET['postId'] : die();


$result = $comment->read();
$num = $result->rowCount();

if ($num > 0) {
    $comments_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $comment_item = array(
            'id' => $id,
            'body' => html_entity_decode($body),
            'user_id' => $user_id,
            'post_id' => $post_id,
            'username' => $username
        );

        array_push($comments_arr, $comment_item);
    }
    http_response_code(200);
    echo json_encode($comments_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array('message' => 'No Comments Found')
    );
}
