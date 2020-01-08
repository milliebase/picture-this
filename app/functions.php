<?php

declare(strict_types=1);

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

function handlePageErrors(string $errorType, string $errorMessage, string $file, string $errorPage)
{
    $_SESSION['errors'][$errorPage][$errorType] = $errorMessage;
    redirect("/$file");
}


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



function fetchUser($pdo, $id)
{
    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');

    $statement->execute([
        ':id' => $id,
    ]);

    return $statement->fetch(PDO::FETCH_ASSOC);
}


function fetchUserByUsername($pdo, $username)
{
    $statement = $pdo->prepare('SELECT id, first_name, last_name, avatar, biography, username
        FROM users WHERE username = :username');

    $statement->execute([
        ':username' => $username,
    ]);

    return $statement->fetch(PDO::FETCH_ASSOC);
}


/*************************POSTS********************/
function getImagePosts($pdo, $id)
{
    $statement = $pdo->prepare('SELECT posts.id, user_id, image, description, date, filter, username
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id
        WHERE users.id = :id
        ORDER by posts.id DESC');


    $statement->execute([
        ':id' => $id,
    ]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


function sortByDate($a, $b)
{
    return ($a['id'] < $b['id']);
}



function getMainFeedPosts($pdo, $userId)
{
    $statement = $pdo->prepare('SELECT DISTINCT follow_id
        FROM user_follows
        WHERE user_id=?');

    $statement->execute([$userId]);

    $follows = $statement->fetchAll(PDO::FETCH_COLUMN);

    $follows[] = $userId;

    $statement = $pdo->prepare('SELECT posts.id, user_id, image, description, date, filter, username
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id
        WHERE user_id=?');

    $allPosts = [];

    foreach ($follows as $follow) {
        $statement->execute([$follow]);

        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($posts as $post) {
            $allPosts[] = $post;
        }

        if (!empty($allPosts)) {
            usort($allPosts, 'sortByDate');
        }

        return $allPosts;
    }
}



function getAmountLikes($pdo, $postId)
{
    $statement = $pdo->prepare('SELECT COUNT(post_likes.post_id)
        FROM posts
        INNER JOIN post_likes
        ON posts.id = post_likes.post_id
        WHERE post_likes.post_id = :post_id');

    $statement->execute([
        ':post_id' => $postId,
    ]);

    return $statement->fetchAll(PDO::FETCH_COLUMN);
}


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

/*************************FOLLOWING/USERS********************/
function isFollowing($pdo, $userId, $followId)
{
    $statement = $pdo->prepare('SELECT * FROM user_follows WHERE user_id = :user_id AND follow_id = :follow_id');

    $statement->execute([
        ':user_id' => $userId,
        ':follow_id' => $followId
    ]);

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getAmountFollowings($pdo, $userId)
{
    $statement = $pdo->prepare('SELECT COUNT(user_id)
        FROM user_follows
        WHERE user_id=?');

    $statement->execute([$userId]);

    $following = $statement->fetch(PDO::FETCH_COLUMN);

    return $following;
}

function getAmountFollowers($pdo, $userId)
{
    $statement = $pdo->prepare('SELECT COUNT(follow_id)
        FROM user_follows
        WHERE follow_id=?');

    $statement->execute([$userId]);

    $followers = $statement->fetch(PDO::FETCH_COLUMN);

    return $followers;
}


/***********************FILTERS*************/
function getFilters($pdo)
{
    $statement = $pdo->prepare('SELECT * FROM filters');

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


/*********************EXECUTE*************/
function executeWithId($id)
{
    $statement->execute([
        'id' => $id,
    ]);
}
