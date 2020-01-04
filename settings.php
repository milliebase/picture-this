<?php require __DIR__ . '/views/header.php'; ?>

<section>
    <h1>Settings</h1>

    <article>
        <h2>Edit biography</h2>

        <form action="app/users/biography.php" method="post" class="form form--new-biography">
            <div class="form-group">
                <textarea name="biography" id="biography" cols="30" rows="10" placeholder="Edit your biography here"><?php echo $user['biography'] ?></textarea>
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </article>

    <article>
        <h2>Change email</h2>

        <p>Current email adress: <?php echo $user['email']; ?></p>

        <?php if (isset($_SESSION['errors']['change-email'])) : ?>
            <p><?php echo $_SESSION['errors']['change-email']; ?></p>
        <?php endif; ?>

        <form action="app/users/email.php" method="post" class="form form--new-email">
            <div class="form-group">
                <label for="email">Update email adress</label>

                <input class="form-control" type="email" name="email" placeholder="Type in your new emailadress" required>
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </article>

    <article>
        <h2>Change password</h2>

        <form action="app/users/password.php" method="post" class="form form--new-password">
            <div class="form-group">
                <?php if (isset($_SESSION['errors']['current-password'])) : ?>
                    <p><?php echo $_SESSION['errors']['current-password']; ?></p>
                <?php endif; ?>
                <label for="current-password">Current password</label>
                <input class="form-control" type="password" name="current-password" placeholder="Type in your current password" required>
            </div><!-- /form-group -->

            <div class="form-group">
                <?php if (isset($_SESSION['errors']['password'])) : ?>
                    <p><?php echo $_SESSION['errors']['password']; ?></p>
                <?php endif; ?>

                <?php if (isset($_SESSION['errors']['short-password'])) : ?>
                    <p><?php echo $_SESSION['errors']['short-password']; ?></p>
                <?php endif; ?>

                <label for="new-password">New password</label>
                <input class="form-control" type="password" name="new-password" placeholder="Type in your new password" required>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="confirm-password">Confirm password</label>
                <input class="form-control" type="password" name="confirm-password" placeholder="Confirm your new password" required>
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </article>
</section>

<?php require __DIR__ . '/views/footer.php'; ?>
