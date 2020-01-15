<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['username'])) {
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));

    $statement = $pdo->prepare('SELECT username FROM users WHERE username = ?');
    $usernameExists = checkIfExists($statement, $username);

    $usernamePatternMatches = preg_match('/^[a-z0-9_\.]{4,}$/', $username);

    if (
        $usernameExists ||
        $usernamePatternMatches === 0
    ) {
        if ($usernameExists) {
            $message = ['error' => 'The username is already taken.'];
            header('Content-Type: application/json');
            echo json_encode($message);
            exit;
        } else if ($usernamePatternMatches === 0) {
            $message = ['error' => 'Usernames can only contain letters, numbers, underscores and periods. The username should be at least 4 characters long.'];
            header('Content-Type: application/json');
            echo json_encode($message);
            exit;
        }
    }

    $statement = $pdo->prepare('UPDATE users SET username = ? WHERE id = ?');
    $statement->execute([
        $username,
        $_SESSION['user']['id'],
    ]);

    $message = ['success' => 'Your username is updated!', "username" => $username];

    header('Content-Type: application/json');
    echo json_encode($message);
}
