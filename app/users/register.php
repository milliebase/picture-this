<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$isEmailValid = true;

if (isset($_POST['first-name'],
$_POST['last-name'],
$_POST['email'],
$_POST['username'],
$_POST['password'],
$_POST['confirm-password'])) {
    $firstName = trim(filter_var($_POST['first-name'], FILTER_SANITIZE_STRING));
    $lastName = trim(filter_var($_POST['last-name'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $username = trim(strtolower(filter_var($_POST['username'], FILTER_SANITIZE_STRING)));

    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    $statement = $pdo->prepare('SELECT email FROM users WHERE email = ?');

    $emailExists = checkIfExists($statement, $email);

    //Check if given email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isEmailValid = false;
    };

    $statement = $pdo->prepare('SELECT username FROM users WHERE username = ?');

    $usernameExists = checkIfExists($statement, $username);

    $usernamePatternMatches = preg_match('/^[a-z0-9_\.]{5,}$/', $username);

    $isFirstNameEmpty = empty($firstName);
    $isLastNameEmpty = empty($lastName);
    $isEmailEmpty = empty($email);

    $_SESSION['register'] = [];

    if (!$isFirstNameEmpty) {
        $_SESSION['register']['first-name'] = $firstName;
    }

    if (!$isLastNameEmpty) {
        $_SESSION['register']['last-name'] = $lastName;
    }

    if (
        !$isEmailValid ||
        $emailExists ||
        $usernameExists ||
        $usernamePatternMatches === 0 ||
        $isFirstNameEmpty ||
        $isLastNameEmpty ||
        $isEmailEmpty ||
        $password !== $confirmPassword ||
        strlen($password) < 8
    ) {
        $_SESSION['errors'] = [];

        if (!$isEmailValid) {
            $_SESSION['errors'][] = 'The email is not valid.';
            redirect('/register.php');
        } else if ($emailExists) {
            $_SESSION['errors'][] = 'The email is already registered.';
            redirect('/register.php');
        } else {
            unset($_SESSION['errors']);

            $_SESSION['register']['email'] = $email;
        }

        if ($usernameExists) {
            $_SESSION['errors'][] = 'The username is already taken.';
            redirect('/register.php');
        } else if ($usernamePatternMatches === 0) {
            $_SESSION['errors'][] = 'Usernames can only contain letters, numbers, underscores and periods. The username should be at least 5 characters long.';
            redirect('/register.php');
        } else {
            unset($_SESSION['errors']);

            $_SESSION['register']['username'] = $username;
        }

        if (
            $isFirstNameEmpty ||
            $isLastNameEmpty ||
            $isEmailEmpty
        ) {
            $_SESSION['errors'][] = 'Please fill in all the fields.';
            redirect('/register.php');
        } else {
            unset($_SESSION['errors']);
        }

        handlePasswordErrors($password, $confirmPassword);
        redirect("/register.php");
    }

    unset($_SESSION['register']);
    unset($_SESSION['errors']);

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $statement = $pdo->prepare('INSERT INTO
    users (first_name, last_name, email, username, password)
    VALUES (:firstName, :lastName, :email, :username, :password)');

    $statement->execute([
        ':firstName' => $firstName,
        ':lastName' => $lastName,
        ':email' => $email,
        ':username' => $username,
        ':password' => $hash,
    ]);

    $_SESSION['user']['id'] = $pdo->lastInsertId();

    redirect('/');
}
