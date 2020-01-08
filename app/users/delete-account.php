<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['delete-account'])) {
    $userId = $_SESSION['user']['id'];

    //Fetch all post ids from user
    $statement = $pdo->prepare('SELECT id FROM posts WHERE user_id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        'id' => $userId,
    ]);

    $posts = $statement->fetch(PDO::FETCH_ASSOC);

    //Delete all likes for posts from user
    $statement = $pdo->prepare('DELETE FROM post_likes WHERE post_id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    foreach ($posts as $post) {
        $statement->execute([
            'id' => $post,
        ]);
    }

    //Delete all likes done by user
    $statement = $pdo->prepare('DELETE FROM post_likes WHERE user_id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        'id' => $userId,
    ]);

    //Deletes users posts
    $statement = $pdo->prepare('DELETE FROM posts WHERE user_id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        'id' => $userId,
    ]);

    //Delete all followings
    $statement = $pdo->prepare('DELETE FROM user_follows WHERE user_id = :id OR follow_id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        'id' => $userId,
    ]);

    //Deletes user
    $statement = $pdo->prepare('DELETE FROM users WHERE id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        'id' => $userId,
    ]);

    session_destroy();

    redirect('/login.php');
}
