<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['delete'], $_GET['post_id'])) {
    $userId = (int) $_SESSION['user']['id'];
    $user = getUser($pdo, $userId);
    $postId = (int) trim(filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT));

    $statement = $pdo->prepare('SELECT image FROM posts WHERE id = ? AND user_id = ?');
    $statement->execute([$postId, $userId]);

    $image = $statement->fetch(PDO::FETCH_ASSOC);

    unlink(__DIR__ . '/../../uploads/' . $image['image']);

    $statement = $pdo->prepare('DELETE FROM posts WHERE id = ? AND user_id = ?');
    $statement->execute([$postId, $userId]);

    $statement = $pdo->prepare('DELETE FROM post_likes WHERE post_id = ?');
    $statement->execute([$postId]);
}

redirect('/profile.php?username=' . $user['username']);
