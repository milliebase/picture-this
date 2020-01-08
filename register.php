<?php require __DIR__ . '/views/header.php'; ?>

<section>
    <h1>Register</h1>

    <div class="error__text">
        <p><?php showErrors(); ?></p>
    </div>

    <form action="app/users/register.php" method="post">
        <div class="form-group">
            <label for="first-name">First name</label>
            <input type="text" name="first-name" placeholder="First name" value="<?php echo getInput('first-name'); ?>" required>
        </div>
        <!--/form-group-->

        <div class="form-group">
            <label for="last-name">Last name</label>
            <input type="text" name="last-name" placeholder="Last name" value="<?php echo getInput('last-name'); ?>" required>
        </div>
        <!--/form-group-->

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" value="<?php echo getInput('email'); ?>" required>
        </div>
        <!--/form-group-->

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" value="<?php echo getInput('username'); ?>" required>
        </div>
        <!--/form-group-->

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <!--/form-group-->

        <div class="form-group">
            <label for="confirm-password">Confirm password</label>
            <input type="password" name="confirm-password" placeholder="Password" required>
        </div>
        <!--/form-group-->

        <button type="submit">Sign up</button>
    </form>
</section>

<?php require __DIR__ . '/views/footer.php'; ?>
