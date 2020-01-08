<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['current-password'], $_POST['new-password'], $_POST['confirm-password'])) {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    $user = fetchUser($pdo, $_SESSION['user']['id']);

    if (!password_verify($currentPassword, $user['password'])) {
        $_SESSION['errors'] = [];

        $_SESSION['errors'][] = 'The password was incorrect.';
        redirect('/settings.php');
    }

    if (
        $newPassword !== $confirmPassword ||
        strlen($newPassword) < 8
    ) {
        handlePasswordErrors($newPassword, $confirmPassword);
        redirect('/settings.php');
    }

    unset($_SESSION['errors']);

    $hash = password_hash($newPassword, PASSWORD_DEFAULT);

    $statement = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');

    $statement->execute([
        ':password' => $hash,
        ':id' => $_SESSION['user']['id'],
    ]);

    redirect('/settings.php');
}
