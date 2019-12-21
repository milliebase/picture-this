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

if (!function_exists('fetchUser')) {
    function fetchUser(PDOStatement $statement, string $email)
    {
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
        if ($_SERVER['REQUEST_URI'] === '/login.php') {
            if (isset($_SESSION['errors'])) {
                foreach ($_SESSION['errors'] as $key => $value) {
                    if ($key !== 'login') {
                        unset($_SESSION['errors'][$key]);
                    }
                }
            }
        }

        if ($_SERVER['REQUEST_URI'] === '/register.php') {
            if (isset($_SESSION['errors']['login'])) {
                unset($_SESSION['errors']['login']);
            }
        }

        if ($_SERVER['REQUEST_URI'] !== '/register.php' && $_SERVER['REQUEST_URI'] !== '/login.php') {
            unset($_SESSION['errors']);
        }
    }
}

if (!function_exists('unsetRegister')) {
    function unsetRegister()
    {
        if ($_SERVER['REQUEST_URI'] !== '/register.php')
            unset($_SESSION['register']);
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
    function isEmpty(string $string)
    {
        if ($string === '') {
            return true;
        }
    }
}

if (!function_exists('getInput')) {
    function getInput(string $inputType)
    {
        if (isset($_SESSION['register'][$inputType])) {
            return $_SESSION['register'][$inputType];
        }
    }
}
