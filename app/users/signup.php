<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

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

    $user = fetchEmail($pdo, $email);

    $isFirstNameEmpty = isEmpty($firstName);
    $isLastNameEmpty = isEmpty($lastName);
    $isEmailEmpty = isEmpty($email);

    $isEmailValid = true;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isEmailValid = false;
    };

    if (
        $isFirstNameEmpty ||
        $isLastNameEmpty ||
        $isEmailEmpty ||
        !$isEmailValid ||
        $user ||
        $password !== $confirmPassword ||
        strlen($password) < 8
    ) {
        $_SESSION['errors'] = [];

        if (
            $isFirstNameEmpty ||
            $isLastNameEmpty ||
            $isEmailEmpty
        ) {
            $blankError = 'Please fill in all the fields.';
            handleErrors('blank', $blankError);
        } else {
            unsetErrorType('blank');
        }

        if (!$isEmailValid) {
            $emailValidationError = 'The email is not valid.';
            handleErrors('emailValidation', $emailValidationError);
        } else if ($user) {
            $emailError = 'The email is already registered.';
            handleErrors('email', $emailError);
        } else {
            unsetErrorType('emailValidation');
            unsetErrorType('email');
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

        redirect('/signup.php');
    }

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

    redirect('/');
}
