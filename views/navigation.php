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
                <a href="/settings.php">Settings</a>
            </li>

            <li>
                <a href="app/users/logout.php">Logout</a>
            </li>

        <?php else : ?>
            <li>
                <a href="/login.php">Login</a>
            </li>
        <?php endif; ?>
    </ul><!-- /navbar-nav -->

    <?php var_dump($_SESSION); ?>
    <?php var_dump($user); ?>
</nav><!-- /navbar -->
