<?php if (isset($_SESSION['user']['id'])) : ?>
    <?php $user = fetchUser($pdo, $_SESSION['user']['id']); ?>

    <section class="navigation">
        <nav class="nav__header">
            <img src="/assets/images/logo_pink.svg" alt="Picture this icon">
            <h1><?php echo $config['title']; ?></h1>
        </nav>

        <nav class="nav__bar">
            <ul class="menu">
                <li class="menu__item">
                    <a href="/index.php"><img src="/assets/images/home.svg" alt="Home icon" class="menu__icon"></a>
                </li><!-- /nav-item -->

                <li class="menu__item">
                    <a href="/search.php"><img src="/assets/images/search.svg" alt="Search icon" class="menu__icon"></a>
                </li><!-- /nav-item -->

                <li class="menu__item">
                    <a href="/create-post.php"><img src="/assets/images/add.svg" alt="Add post icon" class="menu__icon"></a>
                </li><!-- /nav-item -->

                <li class="menu__item">
                    <a href="/profile.php?username=<?php echo $user['username']; ?>"><img src="/assets/images/user.svg" alt="User icon" class="menu__icon"></a>
                </li><!-- /nav-item -->
            </ul><!-- /navbar-nav -->
        </nav><!-- /navbar -->

    </section>
<?php endif; ?>
