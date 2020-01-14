<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = ['error' => 'The email is not a valid emailadress.'];

        header('Content-Type: application/json');
        echo json_encode($message);
        exit;
    }

    $statement = $pdo->prepare('UPDATE users SET email = ? WHERE id = ?');

    $statement->execute([$email, $_SESSION['user']['id']]);

    $message = ['success' => 'Your email is updated!', "email" => $email];

    header('Content-Type: application/json');
    echo json_encode($message);
}
