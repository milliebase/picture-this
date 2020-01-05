<nav>
    <a href="#"><?php echo $config['title']; ?></a>

    <ul>
        <li>
            <a href="/index.php">Home</a>
        </li><!-- /nav-item -->

        <?php if (!isset($_SESSION['user'])) : ?>
            <li>
                <a href="/register.php">Register</a>
            </li><!-- /nav-item -->
        <?php endif; ?>

        <?php if (validateUser()) : ?>
            <li>
                <a href="/profile.php">Profile</a>
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

        <?php else : ?>
            <li>
                <a href="/login.php">Login</a>
            </li><!-- /nav-item -->
        <?php endif; ?>
    </ul><!-- /navbar-nav -->

    <?php var_dump($_SESSION); ?>
</nav><!-- /navbar -->
