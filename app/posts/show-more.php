<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['id'])) {
    $id = trim(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));

    $statement = $pdo->prepare('SELECT description FROM posts WHERE id = ?');

    $statement->execute([$id]);

    $postDescription = $statement->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    echo json_encode($postDescription);
}
