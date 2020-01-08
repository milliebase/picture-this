<?php foreach ($posts as $post) : ?>
    <article class="post">
        <img src="uploads/<?php echo $post['image']; ?>" alt="<?php echo $post['description']; ?>" class="<?php echo $post['filter']; ?>" loading="lazy">

        <div class="post__information">
            <div class="post__details">
                <p><?php echo $post['date']; ?></p>

                <form method="post" class="like__form">
                    <input type="hidden" name="liked-post-id" value="<?php echo $post['id']; ?>">
                    <button type="submit" class="like__button <?php echo (isLiked($pdo, $user['id'], $post['id'])) ? 'like__button--liked' : 'like__button--unliked'; ?>"></button>
                    <p>
                        <?php
                        $likes = getAmountLikes($pdo, $post['id']);
                        echo $likes[0];
                        ?>
                    </p>
                </form>
            </div>

            <div class="post__description">
                <a href="profile.php?username=<?php echo $post['username'] ?>"><?php echo $post['username']; ?></a>
                <p><?php echo $post['description']; ?></p>

                <?php if ($post['user_id'] === $user['id']) : ?>
                    <button class="btn btn-primary">Edit post</button>
                <?php endif; ?>
            </div>
            <!--/information-->

            <?php if ($post['user_id'] === $user['id']) : ?>
                <div class="post__edit hidden">
                    <form method="post" class="edit__form">
                        <label for="description-edit">Edit your description</label>
                        <br>
                        <textarea name="description-edit" cols="30" rows="10"><?php echo $post['description'] ?></textarea>
                        <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                        <br>
                        <button type="submit" name="save" class="btn btn-primary">Save</button>
                    </form>

                    <form action="app/posts/delete.php?post_id=<?php echo $post['id']; ?>" method="post" class="delete__form">
                        <button type="submit" name="delete" class="delete__button btn btn-primary">Delete post</button>
                    </form>
                </div>
                <!--/post__edit-->
            <?php endif; ?>
        </div>
        <!--/post__information-->
    </article>
<?php endforeach; ?>
