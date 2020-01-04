<?php require __DIR__ . '/views/header.php'; ?>

<section class="profile">

    <article class="profile--header">
        <div>
            <img src="<?php echo ($user['avatar'] !== null) ? "avatars/" . $user['avatar'] : 'assets/images/avatar.png'; ?>" alt="Profile picture">
        </div>

        <div>
            <h2><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h2>
            <p> <?php echo $user['biography']; ?></p>
        </div>
    </article>

    <article class="profile--feed">

    </article>

</section>

<?php require __DIR__ . '/views/footer.php'; ?>
