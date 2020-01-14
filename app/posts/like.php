<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['liked-post-id'])) {
    $likerId = (int) $_SESSION['user']['id'];
    $likedPostId = (int) $_POST['liked-post-id'];

    $isLiked = isLiked($pdo, $likerId, $likedPostId);

    if (!$isLiked) {
        $statement = $pdo->prepare('INSERT INTO post_likes (user_id, post_id)
        VALUES (:user_id, :post_id)');

        $statement->execute([
            'user_id' => $likerId,
            'post_id' => $likedPostId,
        ]);

        $likes = getAmountLikes($pdo, $likedPostId);

        header('Content-Type: application/json');

        echo json_encode($likes);
    } else {
        $statement = $pdo->prepare('DELETE FROM post_likes
        WHERE user_id = :user_id AND post_id = :post_id');

        $statement->execute([
            'user_id' => $likerId,
            'post_id' => $likedPostId,
        ]);

        $likes = getAmountLikes($pdo, $likedPostId);

        header('Content-Type: application/json');

        echo json_encode($likes);
    }
}
