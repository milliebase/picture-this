<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['delete'], $_GET['post_id'])) {
    $postId = trim(filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT));
    $userId = $_SESSION['user']['id'];

    $statement = $pdo->prepare('SELECT image FROM posts WHERE id = :id AND user_id = :user_id');

    $statement->execute([
        ':id' => $postId,
        ':user_id' => $userId,
    ]);

    $image = $statement->fetch(PDO::FETCH_ASSOC);

    unlink(__DIR__ . '/../../uploads/' . $image['image']);

    $statement = $pdo->prepare('DELETE FROM posts WHERE id = :id AND user_id = :user_id');

    $statement->execute([
        ':id' => $postId,
        ':user_id' => $userId,
    ]);
}

redirect('/profile.php');
