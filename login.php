<?php require __DIR__ . '/views/header.php'; ?>

<article class="login">
    <div class="login__header">
        <img src="/assets/images/logo_pink.svg" alt="Picture this logo">
        <h1><?php echo $config['title']; ?></h1>
    </div>

    <div class="login__holder">
        <form action="app/users/login.php" method="post" class="form login__form">
            <div class="error__text">
                <p><?php showErrors(); ?></p>
            </div>

            <div class="login__form__input-holder">
                <div class="form__group">
                    <input class="form__input" type="email" name="email" placeholder="email" required>
                </div><!-- /form-group -->

                <div class="form__group">
                    <input class="form__input" type="password" name="password" placeholder="password" required>
                </div><!-- /form-group -->
            </div>


            <button type="submit" class="button button__confirm">Login</button>
        </form>

        <div class="form__text">
            <p>Don't have an account? <a href="/register.php">Register here</a></p>
        </div>
    </div>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
