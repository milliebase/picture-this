<?php require __DIR__ . '/views/header.php';

if (validateUser()) {
    $user = fetchUser($pdo, $_SESSION['user']['id']);
} else {
    redirect('/login.php');
}
?>

<section class="settings">
    <h1>Settings</h1>

    <article class="settings__avatar">
        <h2>Change profile picture</h2>

        <img src="<?php echo ($user['avatar'] !== null) ? "avatars/" . $user['avatar'] : 'assets/images/avatar.png'; ?>" id="avatar-image" alt="Avatar image">

        <?php if (isset($_SESSION['errors'])) : ?>
            <?php foreach ($_SESSION['errors'] as $error) : ?>
                <?php
                echo $error;
                ?>
            <?php
            endforeach;
            unset($_SESSION['errors']);
            ?>
            <p><? ?></p>
        <?php endif; ?>

        <form action="app/users/avatar.php" method="post" enctype="multipart/form-data" class="form settings--avatar--form">
            <div class="form-group">
                <label for="avatar">Choose a new image</label>
                <input class="form-control" type="file" accept="image/jpeg,image/png" name="avatar" id="avatar" required>
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </article>

    <article class="settings__biography">
        <h2>Edit biography</h2>

        <form action="app/users/biography.php" method="post" class="form settings--biography--form">
            <div class="form-group">
                <textarea name="biography" id="biography" cols="30" rows="10" placeholder="Edit your biography here"><?php echo $user['biography'] ?></textarea>
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </article>

    <article class="settings__email">
        <div class="error__text">
            <p><?php showErrors(); ?></p>
        </div>

        <h2>Change email</h2>

        <p>Current email adress: <?php echo $user['email']; ?></p>

        <form action="app/users/email.php" method="post" class="form form__new-email">

            <div class="form-group">
                <label for="email">Update email adress</label>
                <input class="form-control" type="email" name="email" placeholder="Type in your new emailadress" required>
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </article>

    <article class="settings__password">
        <h2>Change password</h2>

        <form action="app/users/password.php" method="post" class="form form__new-password">
            <div class="form-group">

                <label for="current-password">Current password</label>
                <input class="form-control" type="password" name="current-password" placeholder="Type in your current password" required>
            </div><!-- /form-group -->

            <div class="form-group">

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

    <article class="delete-account">
        <button class="delete-account__button">Delete account</button>

        <div class="delete-account__modal hidden">
            <form action="app/users/delete-account.php" method="post" class="form delete-account__form">
                <div class="form-group">
                    <label>Are you sure you want to delete your account?</label>
                    <button type="submit" name="delete-account" class="btn btn-primary">Yes</button>
                </div>
                <!--/form-group-->
            </form>
            <button class="delete-account__cancel">Cancel</button>
        </div>
    </article>
</section>

<?php require __DIR__ . '/views/footer.php'; ?>
