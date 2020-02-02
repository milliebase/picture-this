<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if ($_SESSION['user']['id']) {
    if (isset($_POST['id'], $_POST['comment'])) {
        if (!empty($_POST['comment'])) {
            $comment = trim(filter_var($_POST['comment'], FILTER_SANITIZE_STRING));
            $commentId = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING));
            updateComment($pdo, $comment, $commentId, $_SESSION['user']['id']);
            echo json_encode('Comment updated');
            http_response_code(201);
        }
    }
}
