<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

    $statement = $pdo->prepare("SELECT id, email, password FROM users WHERE email = ?");

    $user = checkIfExists($statement, $email);

    if (!$user || !password_verify($_POST['password'], $user['password'])) {
        $_SESSION['errors'] = [];

        $_SESSION['errors'][] = 'The email or password was incorrect.';
        redirect('/login.php');
    }

    unset($_SESSION['errors']);

    //Protect password from showing in browser
    unset($user['password']);
    unset($user['email']);
    $_SESSION['user'] = $user;

    redirect('/');
}
