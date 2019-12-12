<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    //Prepare the statement
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");

    if (!$statement) {
        redirect('/../login.php');
    }

    //Bind the user input of email with email in statement
    $statement->bindParam(':email', $email, PDO::PARAM_STR);

    //Execute your query
    $statement->execute();

    //Get the first item in database with fetch, if I wanted to get more users
    //I would have used fetchAll and I would fetch an array.
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (password_verify($_POST['password'], $user['password'])) {
        //Protect password from showing in browser
        unset($user['password']);
        $_SESSION['user'] = $user;
    }

    redirect('/');
}
