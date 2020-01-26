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
 * Check if user is logged in.
 *
 * @param PDO $pdo
 * @return void
 */
function authenticateUser(PDO $pdo)
{
    if (isset($_SESSION['user']['id'])) {
        $user = getUser($pdo, (int) $_SESSION['user']['id']);

        return $user;
    } else {
        redirect('/login.php');
    }
}

/**
 * Checks if users input already exists in database
 *
 * @param PDOStatement $statement
 * @param string $userInput
 * @return void
 */
function checkIfExists(PDOStatement $statement, string $userInput)
{
    $statement->execute([$userInput]);

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

/**
 * Print out error and then unsets the error from session.
 *
 * @return void
 */
function showErrors()
{
    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo $error;
        }
        unset($_SESSION['errors']);
    }
}

/**
 * Errorhandling if password doesn't match criteria.
 *
 * @param string $password
 * @param string $confirmPassword
 * @return void
 */
function handlePasswordErrors(string $password, string $confirmPassword)
{
    $_SESSION['errors'] = [];

    if (strlen($password) < 6) {
        $_SESSION['errors'][] = 'The password should at least be 6 characters long.';
    } else if ($password !== $confirmPassword) {
        $_SESSION['errors'][] = 'The passwords do not match.';
    } else {
        unset($_SESSION['errors']);
    }
}


/**
 * Errorhandling if image is not of valid filetype or too big.
 *
 * @param array $image
 * @param integer $imageSize
 * @param string $file
 * @return void
 */
function handleImageErrors(array $imageFile, int $imageSize, string $file)
{
    $_SESSION['errors'] = [];

    if ($imageFile['type'] !== 'image/png' && $imageFile['type'] !== 'image/jpeg') {
        $_SESSION['errors'][] = 'The filetype must be a .jpg, .jpeg or .png.';
        redirect("/$file");
    }

    if ($imageFile['size'] >= $imageSize) {
        $_SESSION['errors'][] = 'The file can\'t exceed 2 MB.';
        redirect("/$file");
    }
}

/**
 * Fetch the stored input type from user.
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
 * Fetch user information by id.
 *
 * @param PDO $pdo
 * @param integer $id
 * @return void
 */
function getUser(PDO $pdo, int $id)
{
    $statement = $pdo->prepare('SELECT * FROM users WHERE id = ?');

    $statement->execute([$id]);

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Fetch user information by username.
 *
 * @param PDO $pdo
 * @param string $username
 * @return void
 */
function getUserByUsername(PDO $pdo, string $username)
{
    $statement = $pdo->prepare('SELECT id, first_name, last_name, avatar, biography, username
        FROM users WHERE username = ?');

    $statement->execute([$username]);

    return $statement->fetch(PDO::FETCH_ASSOC);
}


/*************************POSTS********************/
/**
 * Callback function for sorting items in descending order.
 *
 * @param array $a
 * @param array $b
 * @return void
 */
function sortByDate(array $a, array $b)
{
    return ($a['id'] < $b['id']);
}

/**
 * Fetch users posts.
 *
 * @param PDO $pdo
 * @param integer $id
 * @return void
 */
function getUserPosts(PDO $pdo, int $id)
{
    $statement = $pdo->prepare('SELECT posts.id, user_id, image, description, date, filter, username, avatar
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id
        WHERE users.id = ?
        ORDER by posts.id DESC');


    $statement->execute([$id]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Fetch all posts from user and user followings.
 *
 * @param PDO $pdo
 * @param int $userId
 * @return void
 */
function getMainFeedPosts(PDO $pdo, int $userId)
{
    $statement = $pdo->prepare('SELECT DISTINCT follow_id
        FROM user_follows
        WHERE user_id=?');

    $statement->execute([$userId]);

    $followings = $statement->fetchAll(PDO::FETCH_COLUMN);

    $followings[] = $userId;

    $statement = $pdo->prepare('SELECT posts.id, user_id, image, description, date, filter, username, avatar
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id
        WHERE user_id=?');

    $allPosts = [];

    foreach ($followings as $following) {
        $statement->execute([$following]);

        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($posts as $post) {
            $allPosts[] = $post;
        }
    }

    if (!empty($allPosts)) {
        usort($allPosts, 'sortByDate');
    }

    return $allPosts;
}

/**
 * Fetch all likes for a certain post.
 *
 * @param PDO $pdo
 * @param int $postId
 * @return void
 */
function getAmountLikes(PDO $pdo, int $postId)
{
    $statement = $pdo->prepare('SELECT COUNT(post_likes.post_id)
        FROM posts
        INNER JOIN post_likes
        ON posts.id = post_likes.post_id
        WHERE post_likes.post_id = ?');

    $statement->execute([$postId]);

    return $statement->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * See if user has liked post.
 *
 * @param PDO $pdo
 * @param integer $userId
 * @param integer $postId
 * @return void
 */
function isLiked(PDO $pdo, int $userId, int $postId)
{
    $statement = $pdo->prepare('SELECT *
        FROM post_likes
        WHERE user_id = ?
        AND post_id = ?');

    $statement->execute([$userId, $postId]);

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/*************************FOLLOWING/USERS********************/
/**
 * See if user is following a user.
 *
 * @param PDO $pdo
 * @param integer $userId
 * @param integer $followId
 * @return void
 */
function isFollowing(PDO $pdo, int $userId, int $followId)
{
    $statement = $pdo->prepare('SELECT * FROM user_follows WHERE user_id = ? AND follow_id = ?');

    $statement->execute([$userId, $followId]);

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Fetch user followings.
 *
 * @param PDO $pdo
 * @param integer $userId
 * @return void
 */
function getAmountFollowings(PDO $pdo, int $userId)
{
    $statement = $pdo->prepare('SELECT COUNT(user_id)
        FROM user_follows
        WHERE user_id=?');

    $statement->execute([$userId]);

    $following = $statement->fetch(PDO::FETCH_COLUMN);

    return $following;
}

/**
 * Fetch user followers.
 *
 * @param PDO $pdo
 * @param integer $userId
 * @return void
 */
function getAmountFollowers(PDO $pdo, int $userId)
{
    $statement = $pdo->prepare('SELECT COUNT(follow_id)
        FROM user_follows
        WHERE follow_id=?');

    $statement->execute([$userId]);

    $followers = $statement->fetch(PDO::FETCH_COLUMN);

    return $followers;
}


/***********************FILTERS*************/
/**
 * Fetch all filters
 *
 * @param PDO $pdo
 * @return void
 */
function getFilters(PDO $pdo)
{
    $statement = $pdo->prepare('SELECT * FROM filters');

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get comments for a certain post.
 *
 * @param PDO $pdo
 * @param string $postId
 * @return array
 */
function getComments(PDO $pdo, string $postId): array
{
    $query = "SELECT id, post_id, comment FROM comments
    WHERE comments.post_id = :id ORDER BY comments.id DESC";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $postId, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Create comment for a certain post.
 *
 * @param PDO $pdo
 * @param string $postId
 * @return void
 */
function createComment(PDO $pdo, string $postId, string $userID, string $comment): void
{
    $query = "INSERT INTO comments ('post_id', 'user_id', 'comment') VALUES (:pid, :id, :comment)";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':pid', $postId, PDO::PARAM_STR);
    $statement->bindParam(':id', $userID, PDO::PARAM_STR);
    $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
    $statement->execute();
}

/**
 * Update comment for a certain post.
 *
 * @param PDO $pdo
 * @param string $postId
 * @return void
 */
function updateComment(PDO $pdo, string $comment, string $commentId): void
{
    $query = "UPDATE comments SET comment = :comment WHERE id = :cid";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
    $statement->bindParam(':cid', $commentId, PDO::PARAM_STR);
    $statement->execute();
}

/**
 * Delete comment for a certain post.
 *
 * @param PDO $pdo
 * @param string $commentId
 * @return void
 */
function deleteComment(PDO $pdo, string $commentId): void
{
    $query = "DELETE FROM comments WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $commentId, PDO::PARAM_STR);
    $statement->execute();
}
