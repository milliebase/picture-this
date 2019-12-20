<nav>
    <a href="#"><?php echo $config['title']; ?></a>

    <ul>
        <li>
            <a href="/index.php">Home</a>
        </li><!-- /nav-item -->

        <li>
            <a href="/about.php">About</a>
        </li><!-- /nav-item -->

        <li>
            <a href="/signup.php">Sign Up</a>
        </li><!-- /nav-item -->

        <?php if (isset($_SESSION['user'])) : ?>
            <li>
                <a href="app/users/logout.php">Logout</a>
            </li>
        <?php else : ?>
            <li>
                <a href="/login.php">Login</a>
            </li>
        <?php endif; ?>
    </ul><!-- /navbar-nav -->
</nav><!-- /navbar -->
