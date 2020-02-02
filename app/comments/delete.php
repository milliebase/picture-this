<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if ($_SESSION['user']['id']) {
    if (isset($_POST['id'])) {
        if (!empty($_POST['id'])) {
            $commentId = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING));
            deleteComment($pdo, $commentId, $_SESSION['user']['id']);
            echo json_encode('Comment deleted');
            http_response_code(201);
        }
    }
}
