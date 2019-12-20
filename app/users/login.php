<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    $user = fetchEmail($pdo, $email);

    if (password_verify($_POST['password'], $user['password'])) {
        //Protect password from showing in browser
        unset($user['password']);
        $_SESSION['user'] = $user;
    }

    redirect('/');
}
