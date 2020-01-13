<?php require __DIR__ . '/views/header.php';
//Prevent logged in user to reach this page

if (isset($_SESSION['user']['id'])) {
    redirect('/');
}

?>

<section class="login section">

    <div class="login__header">
        <img src="/assets/images/logo_white.svg" alt="Picture this logo">
        <h1><?php echo $config['title']; ?></h1>
    </div>
    <!--/login__header-->

    <div class="login__holder">
        <form action="app/users/login.php" method="post" class="form login__form">
            <div class="<?php echo ($_SESSION['errors']) ? "message message__error--color" : "message"; ?>">
                <p><?php showErrors(); ?></p>
            </div>
            <!--/error__text-->

            <div class="login__form__input-holder">
                <div class="form__group">
                    <input class="form__input" type="email" name="email" placeholder="email" required>
                </div><!-- /form__group -->

                <div class="form__group">
                    <input class="form__input" type="password" name="password" placeholder="password" required>
                </div><!-- /form__group -->
            </div>
            <!--/login__form__input-holder-->


            <button type="submit" class="button button__confirm">Login</button>
        </form>
        <!--/login__form-->

        <div class="form__text">
            <p>Don't have an account? <a href="/register.php">Register here</a></p>
        </div>
        <!--/form__text-->
    </div>
    <!--/login__holder-->
</section>
<!--/login-->

<?php require __DIR__ . '/views/footer.php'; ?>
