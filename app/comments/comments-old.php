<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if ($_SESSION['user']['id']) {
    if (isset($_POST['id'])) {
        $comments = getComments($pdo, $_POST['id']);
        echo json_encode($comments);
        http_response_code(200);
    }
}
