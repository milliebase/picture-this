<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['biography'])) {
    $biography = trim(filter_var($_POST['biography'], FILTER_SANITIZE_STRING));

    $statement = $pdo->prepare('UPDATE users SET biography = ? WHERE id = ?');

    $statement->execute([$biography, $_SESSION['user']['id']]);

    $message[] = ["success" => "Your biography is updated!"];

    header('Content-Type: application/json');
    echo json_encode($message);
}
