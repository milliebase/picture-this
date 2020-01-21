<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

//add session

if (isset($_POST['id'])) {
    $comments = getComments($pdo, $_POST['id']);

    if ($comments) {
        echo json_encode($comments);
    } else {
        echo json_encode(array('message' => 'No comments'));
    }
    http_response_code(200);
}
