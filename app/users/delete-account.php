<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['delete-account'])) {
    $user = getUser($pdo, (int) $_SESSION['user']['id']);
    $userId = $user['id'];

    $posts = [];

    $statement = $pdo->prepare('SELECT id, image FROM posts WHERE user_id = ?');
    $statement->execute([$userId]);

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    //Deletes users posts
    $statement = $pdo->prepare('DELETE FROM posts WHERE id = ?');

    if (!empty($posts)) {
        foreach ($posts as $post) {
            unlink(__DIR__ . "/../../uploads/" . $post['image']);
            $statement->execute([$post['id']]);
        }
    }

    //Delete all likes for posts from user
    $statement = $pdo->prepare('DELETE FROM post_likes WHERE post_id = ?');

    //Delete all likes done by user
    $statement = $pdo->prepare('DELETE FROM post_likes WHERE user_id = ?');
    $statement->execute([$userId]);

    //Delete all followings
    $statement = $pdo->prepare('DELETE FROM user_follows WHERE user_id = :id OR follow_id = ?');
    $statement->execute([$userId]);

    //Deletes users avatar
    if ($user['avatar'] !== null) {
        unlink(__DIR__ . "/../../uploads/avatars/" . $user['avatar']);
    }

    //Deletes user
    $statement = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $statement->execute([$userId]);

    session_destroy();

    redirect('/login.php');
}
