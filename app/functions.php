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

if (!function_exists('checkIfExists')) {
    /**
     * Checks if users input already exists in database
     *
     * @param PDOStatement $statement
     * @param string $type
     * @param string $
     * @return void
     */
    function checkIfExists(PDOStatement $statement, string $type, string $userInput)
    {
        $statement->execute([
            "$type" => $userInput,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('unsetErrors')) {
    /**
     * On each page load except 'signup' the error messages will be cleared.
     *
     * @return void
     */
    function unsetErrors()
    {
        if ($_SERVER['REQUEST_URI'] === '/login.php' && !isset($_SESSION['user']['id'])) {
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

        if ($_SERVER['REQUEST_URI'] === '/settings.php') {
            if (isset($_SESSION['errors']['create-post'])) {
                unset($_SESSION['errors']);
            }
        }

        if ($_SERVER['REQUEST_URI'] === 'create-post/.php') {
            if (isset($_SESSION['errors']['avatar'])) {
                unset($_SESSION['errors']);
            }
        }

        if (
            $_SERVER['REQUEST_URI'] !== '/register.php' &&
            $_SERVER['REQUEST_URI'] !== '/login.php' &&
            $_SERVER['REQUEST_URI'] !== '/settings.php' &&
            $_SERVER['REQUEST_URI'] !== '/create-post.php'
        ) {
            unset($_SESSION['errors']);
        }
    }
}

if (!function_exists('unsetRegister')) {
    /**
     * On each page load except 'register' the register form will be cleared.
     *
     * @return void
     */
    function unsetRegister()
    {
        if ($_SERVER['REQUEST_URI'] !== '/register.php')
            unset($_SESSION['register']);
    }
}

if (!function_exists('unsetErrorType')) {
    /**
     * Clear the error array of a certain error type.
     *
     * @param string $errorType
     * @return void
     */
    function unsetErrorType(string $errorType)
    {
        unset($_SESSION['errors'][$errorType]);
    }
}

if (!function_exists('handleErrors')) {
    /**
     * Assign an errormessage to the error array depending on which errortype.
     *
     * @param string $errorType
     * @param string $errorMessage
     * @param string $file
     * @return void
     */
    function handleErrors(string $errorType, string $errorMessage, string $file)
    {
        $_SESSION['errors'][$errorType] = $errorMessage;
        redirect("/$file");
    }
}

if (!function_exists('handlePageErrors')) {
    function handlePageErrors(string $errorType, string $errorMessage, string $file, string $errorPage)
    {
        $_SESSION['errors'][$errorPage][$errorType] = $errorMessage;
        redirect("/$file");
    }
}

if (!function_exists('handlePasswordErrors')) {
    function handlePasswordErrors($password, $confirmPassword)
    {
        if (strlen($password) < 8) {
            $shortPasswordError = 'The password should at least be 8 characters long.';
            $_SESSION['errors']['short-password'] = $shortPasswordError;
        } else if ($password !== $confirmPassword) {
            $passwordError = 'The passwords do not match.';
            $_SESSION['errors']['password'] = $passwordError;
        } else {
            unsetErrorType('short-password');
            unsetErrorType('password');
        }
    }
}

if (!function_exists('handleImageErrors')) {
    function handleImageErrors($image, $imageSize, $file, $errorPage)
    {
        if ($image['type'] !== 'image/png' && $image['type'] !== 'image/jpeg') {
            $_SESSION['errors'] = [];

            $unvalidFiletypeError = 'The filetype must be a .jpg, .jpeg or .png.';
            handlePageErrors('unvalid-filetype', $unvalidFiletypeError, $file, $errorPage);
        }


        if ($image['size'] >= $imageSize) {
            $_SESSION['errors'] = [];

            $largeFileError = 'The file can\'t exceed 2 MB.';
            handlePageErrors('large-file', $largeFileError, $file, $errorPage);
        }
    }
}

if (!function_exists('isEmpty')) {
    /**
     * Check if string is empty.
     *
     * @param string $string
     * @return boolean
     */
    function isEmpty(string $string)
    {
        if ($string === '') {
            return true;
        }
    }
}

if (!function_exists('getInput')) {
    /**
     * Fetch the input type from the register form.
     *
     * @param string $inputType
     * @return void
     */
    function getInput(string $inputType)
    {
        if (isset($_SESSION['register'][$inputType])) {
            return $_SESSION['register'][$inputType];
        }
    }
}

if (!function_exists('validateUser')) {
    /**
     * Check if user is logged in.
     *
     * @return void
     */
    function validateUser()
    {
        if (isset($_SESSION['user']['id'])) {
            return true;
        }
    }
}

if (!function_exists('fetchUser')) {
    function fetchUser($pdo, $id)
    {
        $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');

        $statement->execute([
            ':id' => $id,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('fetchUserByUsername')) {
    function fetchUserByUsername($pdo, $username)
    {
        $statement = $pdo->prepare('SELECT id, first_name, last_name, avatar, biography, username
        FROM users WHERE username = :username');

        $statement->execute([
            ':username' => $username,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

/*************************POSTS********************/
if (!function_exists('getImagePosts')) {
    function getImagePosts($pdo, $id)
    {
        $statement = $pdo->prepare('SELECT posts.id, image, description, date
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id
        WHERE users.id = :id
        ORDER by date DESC');


        $statement->execute([
            ':id' => $id,
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('getAmountLikes')) {
    function getAmountLikes($pdo, $postId)
    {
        $statement = $pdo->prepare('SELECT post_likes.post_id
        FROM posts
        INNER JOIN post_likes
        ON posts.id = post_likes.post_id
        WHERE post_likes.post_id = :post_id');

        $statement->execute([
            ':post_id' => $postId,
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('isLiked')) {
    function isLiked($pdo, $userId, $postId)
    {
        $statement = $pdo->prepare('SELECT *
        FROM post_likes
        WHERE user_id = :user_id
        AND post_id = :post_id');

        $statement->execute([
            ':user_id' => $userId,
            ':post_id' => $postId,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

/*************************FOLLOWING/USERS********************/
if (!function_exists('isFollowing')) {
    function isFollowing($pdo, $userId, $followId)
    {
        $statement = $pdo->prepare('SELECT * FROM user_follows WHERE user_id = :user_id AND follow_id = :follow_id');

        $statement->execute([
            ':user_id' => $userId,
            ':follow_id' => $followId
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
