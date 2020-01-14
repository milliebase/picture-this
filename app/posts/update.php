<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['description-edit'], $_POST['id'])) {
    $description = trim(filter_var($_POST['description-edit'], FILTER_SANITIZE_STRING));
    $id = trim(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
    $userId = (int) $_SESSION['user']['id'];

    $statement = $pdo->prepare('UPDATE posts SET description = ? WHERE id = ? AND user_id = ?');

    $statement->execute([$description, $id, $userId]);

    $statement = $pdo->prepare('SELECT * FROM posts WHERE id = ? AND user_id = ?');

    $statement->execute([$id, $userId]);

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    echo json_encode($post);
}
