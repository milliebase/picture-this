<?php

declare(strict_types=1);

if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}

if (!function_exists('fetchEmail')) {
    /**
     * Fetch emailadress from database.
     *
     * @param PDO $pdo
     * @param string $email
     *
     * @return array
     */
    function fetchEmail(PDO $pdo, string $email)
    {
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");

        $statement->execute([
            ':email' => $email,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('unsetErrors')) {
    /**
     * On each page load except signup the error messages will be cleared.
     *
     * @return void
     */
    function unsetErrors()
    {
        if ($_SERVER['REQUEST_URI'] != '/signup.php') {
            unset($_SESSION['errors']);
        }
    }
}

if (!function_exists('unsetErrorType')) {
    function unsetErrorType(string $errorType)
    {
        unset($_SESSION['errors'][$errorType]);
    }
}

if (!function_exists('handleErrors')) {
    function handleErrors(string $errorType, string $errorMessage)
    {
        foreach ($_SESSION['errors'] as $sessionError) {
            if ($sessionError === $errorMessage) {
                redirect('/signup.php');
            }
        }

        $_SESSION['errors'][$errorType] = $errorMessage;
    }
}

if (!function_exists('isEmpty')) {
    function isEmpty($string)
    {
        if ($string === '') {
            return true;
        }
    }
}
