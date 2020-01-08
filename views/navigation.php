<?php
if (validateUser()) {
    $user = fetchUser($pdo, $_SESSION['user']['id']);
}
?>

<nav>
    <ul>
        <?php if (validateUser()) : ?>
            <li>
                <a href="/index.php">Home</a>
            </li><!-- /nav-item -->

            <li>
                <a href="/profile.php?username=<?php echo $user['username']; ?>">Profile</a>
            </li><!-- /nav-item -->

            <li>
                <a href="/create-post.php">Add posts</a>
            </li><!-- /nav-item -->

            <li>
                <a href="/settings.php">Settings</a>
            </li><!-- /nav-item -->

            <li>
                <a href="app/users/logout.php">Logout</a>
            </li><!-- /nav-item -->
        <?php endif; ?>
    </ul><!-- /navbar-nav -->
</nav><!-- /navbar -->
