<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if ($_SESSION['user']['id']) {
    if (isset($_POST['id'], $_POST['comment'])) {
        if (!empty($_POST['comment'])) {
            createComment($pdo, $_POST['id'], $_SESSION['user']['id'], $_POST['comment']);
            echo json_encode('hej');
            http_response_code(201);
        }
    }
}
