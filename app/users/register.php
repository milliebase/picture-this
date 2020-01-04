<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$isEmailValid = true;
$file = 'register.php';

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

    $statement = $pdo->prepare('SELECT email FROM users WHERE email = :email');

    $emailExists = checkEmail($statement, $email);

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
            handleErrors('emailValidation', $emailValidationError, $file);
        } else if ($emailExists) {
            $emailError = 'The email is already registered.';
            handleErrors('email', $emailError, $file);
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
