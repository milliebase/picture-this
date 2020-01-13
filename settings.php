<?php require __DIR__ . '/views/header.php';
$user = authenticateUser($pdo);
?>

<section class="settings section">
    <div class="settings__menu">
        <article class="settings__menu__item change-avatar">
            <h2>Change profile picture</h2>

            <div class="settings__menu__item--active change-avatar--active hidden">

                <div class="message hidden">
                    <p></p>
                </div>

                <img src="<?php echo ($user['avatar'] !== null) ? "/uploads/avatars/" . $user['avatar'] : 'assets/images/avatar.png'; ?>" id="avatar-image" alt="Avatar image">

                <form method="post" enctype="multipart/form-data" class="form change-avatar__form">
                    <div class="form__group">
                        <input class="form-control" type="file" accept="image/jpeg,image/png" name="avatar" id="avatar" required>
                    </div><!-- /form__group -->

                    <button type="submit" class="button">Upload</button>
                </form>
            </div>
        </article>

        <article class="settings__menu__item change-biography">
            <h2>Edit biography</h2>

            <div class="settings__menu__item--active change-biography--active hidden">
                <div class="message hidden">
                    <p></p>
                </div>

                <form action="app/users/biography.php" method="post" class="form change-biography__form">
                    <div class="form__group">
                        <textarea name="biography" id="biography" cols="30" rows="10" placeholder="Edit your biography here"><?php echo $user['biography'] ?></textarea>
                    </div><!-- /form__group -->

                    <button type="submit" class="button">Save</button>
                </form>
            </div>
        </article>

        <article class="settings__menu__item change-email">
            <h2>Change email</h2>

            <div class="settings__menu__item--active change-email--active hidden">
                <div class="message hidden">
                    <p></p>
                </div>

                <p>Current email adress: <?php echo $user['email']; ?></p>

                <form method="post" class="form change-email__form">
                    <div class="form__group">
                        <input class="form-control" type="email" name="email" placeholder="Type in your new emailadress" required>
                    </div><!-- /form__group -->

                    <button type="submit" class="button">Save</button>
                </form>
            </div>
        </article>

        <article class="settings__menu__item change-password">
            <h2>Change password</h2>

            <div class="settings__menu__item--active change-password--active hidden">
                <div class="message hidden">
                    <p></p>
                </div>

                <form action="app/users/password.php" method="post" class="form change-password__form">
                    <div class="form__group">

                        <label for="current-password">Current password</label>
                        <input type="password" name="current-password" placeholder="Type in your current password" required>
                    </div><!-- /form__group -->

                    <div class="form__group">
                        <label for="new-password">New password</label>
                        <input type="password" name="new-password" placeholder="Type in your new password" required>
                    </div><!-- /form__group -->

                    <div class="form__group">
                        <label for="confirm-password">Confirm password</label>
                        <input type="password" name="confirm-password" placeholder="Confirm your new password" required>
                    </div><!-- /form__group -->

                    <button type="submit" class="button">Save</button>
                </form>
            </div>
        </article>

        <article class="settings__menu__item delete-account">
            <h2>Delete account</h2>

            <div class="settings__menu__item--active delete-account--active hidden">
                <button class="button delete-account__button">Delete account</button>

                <div class="delete-account__modal hidden">
                    <form action="app/users/delete-account.php" method="post" class="form delete-account__form">
                        <div class="form__group">
                            <label>Are you sure you want to delete your account?</label>
                            <button type="submit" name="delete-account" class="button">Yes</button>
                        </div>
                        <!--/form__group-->
                    </form>
                    <button class="button delete-account__cancel">Cancel</button>
                </div>
            </div>
        </article>
    </div>

    <form action="app/users/logout.php" class="logout">
        <button type="submit" class="button">Logout</button>
    </form>
</section>

<?php require __DIR__ . '/views/footer.php'; ?>
