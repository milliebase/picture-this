<?php require __DIR__ . '/views/header.php'; ?>

<section>
    <h1>Sign up</h1>

    <?php if (isset($_SESSION['errors'])) : ?>
        <?php $errors = $_SESSION['errors'] ?>
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="app/users/signup.php" method="post">
        <div class="form-group">
            <label for="first-name">First name</label>
            <input type="text" name="first-name" placeholder="First name" required>
        </div>
        <!--/form-group-->

        <div class="form-group">
            <label for="last-name">Last name</label>
            <input type="text" name="last-name" placeholder="Last name" required>
        </div>
        <!--/form-group-->

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
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
