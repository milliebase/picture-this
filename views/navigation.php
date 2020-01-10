<?php if (isset($_SESSION['user']['id'])) : ?>
    <?php $user = fetchUser($pdo, $_SESSION['user']['id']); ?>

    <nav>
        <ul>
            <li>
                <a href="/index.php">Home</a>
            </li><!-- /nav-item -->

            <li>
                <a href="/search.php">Search</a>
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
        </ul><!-- /navbar-nav -->
    </nav><!-- /navbar -->
<?php endif; ?>
