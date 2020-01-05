<?php require __DIR__ . '/views/header.php'; ?>

<section class="profile">

    <article class="profile--header">
        <div>
            <img src="<?php echo ($user['avatar'] !== null) ? "avatars/" . $user['avatar'] : 'assets/images/avatar.png'; ?>" alt="Profile picture">
        </div>

        <div>
            <h2><?php echo $user['username']; ?></h2>
            <p><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></p>
            <p> <?php echo $user['biography']; ?></p>
        </div>
    </article>

    <article class="profile--feed">
        <?php $posts = getImagePosts($pdo, $_SESSION['user']['id']); ?>

        <?php if (empty($posts)) : ?>
            <p>There are no posts yet.</p>
        <?php endif; ?>

        <?php foreach ($posts as $post) : ?>
            <div class="feed--post">
                <img src="uploads/<?php echo $post['image']; ?>" alt="<?php echo $post['description']; ?>" loading="lazy">

                <div class="post--information">
                    <p><?php echo $post['date']; ?></p>
                    <p><?php echo $post['description']; ?></p>

                    <form method="post" class="edit--form edit--unactive">
                        <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                        <button type=" submit" class="btn btn-primary">Edit post</button>
                    </form>
                </div>
                <!--/post--information-->

                <!-- <div class="post--edit hidden">
                    <form method="post" class="edit--form edit--active">
                        <label for="description-edit">Edit your description</label>
                        <br>
                        <textarea name="description-edit" cols="30" rows="10"><?php echo $post['description'] ?></textarea>
                        <br>
                        <button type=" submit" name="save" class="btn btn-primary">Save</button>
                        <button type=" submit" name="cancel" class="btn btn-primary">Cancel</button>
                    </form>
                </div>
            </div> -->
                <!--/feed--post-->
            <?php endforeach; ?>
    </article>

</section>

<?php require __DIR__ . '/views/footer.php'; ?>
