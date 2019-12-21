<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$isEmailValid = true;

if (isset($_POST['first-name'],
$_POST['last-name'],
$_POST['email'],
$_POST['password'],
$_POST['confirm-password'])) {
    $firstName = trim(filter_var($_POST['first-name'], FILTER_SANITIZE_STRING));
    $lastName = trim(filter_var($_POST['last-name'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    $statement = $pdo->prepare("SELECT email FROM users WHERE email = :email");

    $emailExists = fetchUser($statement, $email);

    //Check if given email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isEmailValid = false;
    };

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
        $isFirstNameEmpty ||
        $isLastNameEmpty ||
        $isEmailEmpty ||
        !$isEmailValid ||
        $emailExists ||
        $password !== $confirmPassword ||
        strlen($password) < 8
    ) {
        $_SESSION['errors'] = [];

        if (!$isEmailValid) {
            $emailValidationError = 'The email is not valid.';
            handleErrors('emailValidation', $emailValidationError);

            redirect('/register.php');
        } else if ($emailExists) {
            $emailError = 'The email is already registered.';
            handleErrors('email', $emailError);

            redirect('/register.php');
        } else {
            unsetErrorType('emailValidation');
            unsetErrorType('email');

            $_SESSION['register']['email'] = $email;
        }

        if (
            $isFirstNameEmpty ||
            $isLastNameEmpty ||
            $isEmailEmpty
        ) {
            $blankError = 'Please fill in all the fields.';
            handleErrors('blank', $blankError);

            redirect('/register.php');
        } else {
            unsetErrorType('blank');
        }

        if (strlen($password) < 8) {
            $shortPasswordError = 'The password should at least be 8 characters long.';
            handleErrors('shortPassword', $shortPasswordError);
        } else if ($password !== $confirmPassword) {
            $passwordError = 'The passwords do not match.';
            handleErrors('password', $passwordError);
        } else {
            unsetErrorType('shortPassword');
            unsetErrorType('password');
        }

        redirect('/register.php');
    }

    unset($_SESSION['register']);
    unset($_SESSION['errors']);

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $statement = $pdo->prepare('INSERT INTO
    users (first_name, last_name, email, password)
    VALUES (:firstName, :lastName, :email, :password)');

    $statement->execute([
        ':firstName' => $firstName,
        ':lastName' => $lastName,
        ':email' => $email,
        ':password' => $hash,
    ]);

    $_SESSION['user']['id'] = $pdo->lastInsertId();

    redirect('/');
}
