<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['current-password'], $_POST['new-password'], $_POST['confirm-password'])) {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    $user = getUser($pdo, (int) $_SESSION['user']['id']);

    if (!password_verify($currentPassword, $user['password'])) {
        $message = ['error' => 'The password was incorrect.'];

        header('Content-Type: application/json');
        echo json_encode($message);
        exit;
    }

    if (
        $newPassword !== $confirmPassword ||
        strlen($newPassword) < 8
    ) {
        if (strlen($newPassword) < 8) {
            $message = ['error' => 'The password should at least be 8 characters long.'];

            header('Content-Type: application/json');
            echo json_encode($message);
            exit;
        } else if ($newPassword !== $confirmPassword) {
            $message = ['error' => 'The passwords do not match.'];

            header('Content-Type: application/json');
            echo json_encode($message);
            exit;
        }
    }

    unset($_SESSION['errors']);

    $hash = password_hash($newPassword, PASSWORD_DEFAULT);

    $statement = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');

    $statement->execute([$hash, $_SESSION['user']['id']]);

    $message = ['success' => 'Your password is updated!'];

    header('Content-Type: application/json');
    echo json_encode($message);
}
