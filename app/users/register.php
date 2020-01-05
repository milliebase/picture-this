<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$isEmailValid = true;
$file = 'register.php';

if (isset($_POST['first-name'],
$_POST['last-name'],
$_POST['email'],
$_POST['username'],
$_POST['password'],
$_POST['confirm-password'])) {
    $firstName = trim(filter_var($_POST['first-name'], FILTER_SANITIZE_STRING));
    $lastName = trim(filter_var($_POST['last-name'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));

    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    $statement = $pdo->prepare('SELECT email FROM users WHERE email = :email');

    $emailExists = checkIfExists($statement, ':email', $email);

    //Check if given email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isEmailValid = false;
    };

    $statement = $pdo->prepare('SELECT username FROM users WHERE username = :username');

    $usernameExists = checkIfExists($statement, ':username', $username);

    $usernamePatternMatches = preg_match('/^[a-z0-9_\.]{5,}$/', $username);

    $isFirstNameEmpty = isEmpty($firstName);
    $isLastNameEmpty = isEmpty($lastName);
    $isEmailEmpty = isEmpty($email);

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
            $emailValidationError = 'The email is not valid.';
            handleErrors('emailValidation', $emailValidationError, $file);
        } else if ($emailExists) {
            $emailError = 'The email is already registered.';
            handleErrors('email', $emailError, $file);
        } else {
            unsetErrorType('emailValidation');
            unsetErrorType('email');

            $_SESSION['register']['email'] = $email;
        }

        if ($usernameExists) {
            $usernameError = 'The username is already taken.';
            handleErrors('username', $usernameError, $file);
        } else if ($usernamePatternMatches === 0) {
            $usernameCharError = 'Usernames can only contain letters, numbers, underscores and periods. The username should be at least 5 characters long.';
            handleErrors('username-char', $usernameCharError, $file);
        } else {
            unsetErrorType('username-char');
            unsetErrorType('username');
            $_SESSION['register']['username'] = $username;
        }

        if (
            $isFirstNameEmpty ||
            $isLastNameEmpty ||
            $isEmailEmpty
        ) {
            $blankError = 'Please fill in all the fields.';
            handleErrors('blank', $blankError, $file);
        } else {
            unsetErrorType('blank');
        }

        handlePasswordErrors($password, $confirmPassword);
        redirect("/$file");
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
