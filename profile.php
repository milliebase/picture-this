<?php require __DIR__ . '/views/header.php';

$user = authenticateUser($pdo);

if (isset($_GET['username'])) {
    $username = trim(filter_var($_GET['username'], FILTER_SANITIZE_STRING));
    $profile = fetchUserByUsername($pdo, $username);
}

?>

<section class="profile">

    <?php if (!$profile) : ?>
        <article class="error--user">
            <h2>Sorry, the user does not exist.</h2>
            <a href="index.php">Go back to Picture This.</a>
        </article>
    <?php else : ?>

        <article class="profile__header">
            <div>
                <img src="<?php echo ($profile['avatar'] !== null) ? "avatars/" . $profile['avatar'] : 'assets/images/avatar.png'; ?>" alt="Profile picture">
            </div>

            <div>
                <h2><?php echo $profile['username']; ?></h2>
                <p><?php echo $profile['first_name'] . ' ' . $profile['last_name']; ?></p>
                <p> <?php echo $profile['biography']; ?></p>

                <div class="follow">
                    <div class="follow__item following">
                        <p>Following</p>
                        <p class="following__number"><?php echo getAmountFollowings($pdo, $profile['id']); ?></p>
                    </div>
                    <div class="follow__item followers">
                        <p>Followers</p>
                        <p class="followers__number"><?php echo getAmountFollowers($pdo, $profile['id']); ?></p>
                    </div>
                </div>


                <?php if ($profile['id'] !== $user['id']) : ?>
                    <form method="post" class="follow__form">
                        <input type="hidden" name="profile-id" value="<?php echo $profile['id']; ?>">
                        <button type="submit" class="follow__button btn btn-primary">
                            <?php echo (!isFollowing($pdo, $user['id'], $profile['id']) ? 'Follow' : 'Unfollow'); ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </article>

        <article class="profile__feed">
            <?php $posts = getImagePosts($pdo, $profile['id']); ?>

            <?php if (empty($posts)) : ?>
                <p>There are no posts yet.</p>
            <?php endif; ?>

            <?php require __DIR__ . '/posts.php'; ?>

        </article>

    <?php endif; ?>

</section>

<?php require __DIR__ . '/views/footer.php'; ?>
