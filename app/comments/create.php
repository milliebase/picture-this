<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if ($_SESSION['user']['id']) {
    if (isset($_POST['id'], $_POST['comment'])) {
        if (!empty($_POST['comment'])) {
            $postId = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING));
            $comment = trim(filter_var($_POST['comment'], FILTER_SANITIZE_STRING));
            createComment($pdo, $postId, $_SESSION['user']['id'], $comment);
            echo json_encode('Comment added');
            http_response_code(201);
        }
    }
}
