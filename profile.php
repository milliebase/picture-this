<?php require __DIR__ . '/views/header.php';

if (isset($_SESSION['user']['id'])) {
    $user = fetchUser($pdo, $_SESSION['user']['id']);
} else {
    redirect('/login.php');
}
?>

<section class="profile">

    <article class="profile__header">
        <div>
            <img src="<?php echo ($user['avatar'] !== null) ? "avatars/" . $user['avatar'] : 'assets/images/avatar.png'; ?>" alt="Profile picture">
        </div>

        <div>
            <h2><?php echo $user['username']; ?></h2>
            <p><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></p>
            <p> <?php echo $user['biography']; ?></p>
        </div>
    </article>

    <article class="profile__feed">
        <?php $posts = getImagePosts($pdo, $_SESSION['user']['id']); ?>

        <?php if (empty($posts)) : ?>
            <p>There are no posts yet.</p>
        <?php endif; ?>

        <?php foreach ($posts as $post) : ?>
            <div class="post">
                <img src="uploads/<?php echo $post['image']; ?>" alt="<?php echo $post['description']; ?>" loading="lazy">

                <div class="post__information">
                    <p><?php echo $post['date']; ?></p>
                    <div class="information">
                        <p><?php echo $post['description']; ?></p>

                        <button class="btn btn-primary">Edit post</button>
                    </div>
                    <!--/information-->

                    <div class="edit-mode">
                        <form action="app/posts/update.php" method="post" class="edit-mode__form hidden">
                            <label for="description-edit">Edit your description</label>
                            <br>
                            <textarea name="description-edit" cols="30" rows="10"><?php echo $post['description'] ?></textarea>
                            <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                            <br>
                            <button type="submit" name="save" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                    <!--/edit-mode-->
                </div>
                <!--/post__information-->
            </div>
            <!--/post-->
        <?php endforeach; ?>
    </article>

</section>

<?php require __DIR__ . '/views/footer.php'; ?>
