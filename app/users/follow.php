<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['profile-id'])) {
    $userId = (int) $_SESSION['user']['id'];
    $profileId = (int) trim(filter_var($_POST['profile-id'], FILTER_SANITIZE_NUMBER_INT));

    if (filter_var($profileId, FILTER_VALIDATE_INT)) {
        $isFollowing = isFollowing($pdo, $userId, $profileId);

        if (!$isFollowing) {
            $statement = $pdo->prepare('INSERT INTO user_follows (user_id, follow_id)
            VALUES (:user_id, :follow_id)');

            $statement->execute([
                ':user_id' => $userId,
                ':follow_id' => $profileId,
            ]);

            header('Content-Type: application/json');

            $followers = getAmountFollowers($pdo, $profileId);

            echo json_encode($followers);
            exit;
        } else {
            $statement = $pdo->prepare('DELETE FROM user_follows
            WHERE user_id = :user_id AND follow_id = :follow_id');

            $statement->execute([
                ':user_id' => $userId,
                ':follow_id' => $profileId,
            ]);

            header('Content-Type: application/json');

            $followers = getAmountFollowers($pdo, $profileId);

            echo json_encode($followers);
            exit;
        }
    }
}
