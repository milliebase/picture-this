<?php require __DIR__ . '/views/header.php';

//Prevent logged in user to reach this page
if (isset($_SESSION['user']['id'])) {
    redirect('/');
}

?>

<section class="register section">
    <h1>Register</h1>


    <div class="register__holder">
        <div class="message <?php echo (isset($_SESSION['errors'])) ? 'message__error--color' : ''; ?>">
            <p><?php showErrors(); ?></p>
        </div>

        <form action=" app/users/register.php" method="post" class="form register__form">
            <div class="form__group">
                <label for="first-name">First name*</label>
                <input type="text" id="register__first-name" name="first-name" value="<?php echo getInput('first-name'); ?>" placeholder="Kalle" required>
            </div>
            <!--/form-group-->

            <div class="form__group">
                <label for="last-name">Last name*</label>
                <input type="text" id="register__last-name" name="last-name" value="<?php echo getInput('last-name'); ?>" placeholder="Anka" required>
            </div>
            <!--/form__group-->

            <div class="form__group">
                <label for="email">E-mail*</label>
                <input type="email" id="register__email" name="email" value="<?php echo getInput('email'); ?>" placeholder="kalle@kalleanka.se" required>
            </div>
            <!--/form__group-->

            <div class="form__group">
                <label for="username">Username*</label>
                <input type="text" id="register__username" name="username" value="<?php echo getInput('username'); ?>" placeholder="ex. &quot;kalle&quot;, &quot;kalle_2020&quot;" required>
            </div>
            <!--/form__group-->

            <div class=" form__group">
                <label for="password">Password*</label>
                <input type="password" id="register__password" name="password" placeholder="Minimum of 8 characters" required>
            </div>
            <!--/form__group-->

            <div class="form__group">
                <label for="confirm-password">Confirm password*</label>
                <input type="password" id="register__confirm-password" name="confirm-password" placeholder="Confirm password" required>
            </div>
            <!--/form__group-->

            <button type="submit" class="button button--disabled">Sign up</button>
        </form>
    </div>
</section>

<?php require __DIR__ . '/views/footer.php'; ?>
