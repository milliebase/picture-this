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
 * On each page load except 'register' the register form will be cleared.
 *
 * @return void
 */
function unsetRegister()
{
    if ($_SERVER['REQUEST_URI'] !== '/register.php')
        unset($_SESSION['register']);
}

function showErrors()
{
    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo $error;
        }
        unset($_SESSION['errors']);
    }
}

function handlePasswordErrors($password, $confirmPassword)
{
    $_SESSION['errors'] = [];

    if (strlen($password) < 8) {
        $_SESSION['errors'][] = 'The password should at least be 8 characters long.';
    } else if ($password !== $confirmPassword) {
        $_SESSION['errors'][] = 'The passwords do not match.';
    } else {
        unset($_SESSION['errors']);
    }
}

function handleImageErrors($image, $imageSize, $file)
{
    $_SESSION['errors'] = [];

    if ($image['type'] !== 'image/png' && $image['type'] !== 'image/jpeg') {
        $_SESSION['errors'][] = 'The filetype must be a .jpg, .jpeg or .png.';
        redirect("/$file");
    }

    if ($image['size'] >= $imageSize) {
        $_SESSION['errors'][] = 'The file can\'t exceed 2 MB.';
        redirect("/$file");
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
function authenticateUser($pdo)
{
    if (isset($_SESSION['user']['id'])) {
        $user = fetchUser($pdo, $_SESSION['user']['id']);

        return $user;
    } else {
        redirect('/login.php');
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
function executeWithId($statement, $id)
{
    $statement->execute([
        'id' => $id,
    ]);
}
