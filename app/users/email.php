<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'] = [];

        $changeEmailError = 'The email is not a valid emailadress.';
        handleErrors('change-email', $changeEmailError);

        redirect('/settings.php');
    }

    $statement = $pdo->prepare('UPDATE users SET email = :email WHERE id = :id');

    $statement->execute([
        ':email' => $email,
        ':id' => $_SESSION['user']['id'],
    ]);

    redirect('/settings.php');
}
