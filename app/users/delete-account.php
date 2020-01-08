<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['delete-account'])) {
    $userId = $_SESSION['user']['id'];

    //Fetch all post ids from user
    $statement = $pdo->prepare('SELECT id FROM posts WHERE user_id = :id');
    executeWithId($statement, $userId);

    $posts = $statement->fetch(PDO::FETCH_ASSOC);

    //Delete all likes for posts from user
    $statement = $pdo->prepare('DELETE FROM post_likes WHERE post_id = :id');

    foreach ($posts as $post) {
        $statement->execute([
            'id' => $post,
        ]);
    }

    //Delete all likes done by user
    $statement = $pdo->prepare('DELETE FROM post_likes WHERE user_id = :id');
    executeWithId($statement, $userId);

    //Deletes users posts
    $statement = $pdo->prepare('DELETE FROM posts WHERE user_id = :id');
    executeWithId($statement, $userId);

    //Delete all followings
    $statement = $pdo->prepare('DELETE FROM user_follows WHERE user_id = :id OR follow_id = :id');
    executeWithId($statement, $userId);

    //Deletes user
    $statement = $pdo->prepare('DELETE FROM users WHERE id = :id');
    executeWithId($statement, $userId);

    session_destroy();

    redirect('/login.php');
}
