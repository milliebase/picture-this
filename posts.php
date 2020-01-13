<?php if ($posts) : ?>
    <?php foreach ($posts as $post) : ?>
        <div class="post">
            <div class="post__user">
                <div class="post__user--username">
                    <a href="profile.php?username=<?php echo $post['username'] ?>">
                        <img src="<?php echo ($post['avatar'] !== null) ? "/uploads/avatars/" . $post['avatar'] : 'assets/images/avatar.png'; ?>" alt="<?php echo $post['username']; ?>'s profile picture">
                        <p><?php echo $post['username']; ?></p>
                    </a>
                </div>


                <?php if ($post['user_id'] === $user['id']) : ?>
                    <div class="post__user--settings">
                        <img src="/assets/images/kebab.svg" alt="Kebab menu icon">
                    </div>
                <?php endif; ?>
            </div>
            <!--/post__user-->

            <div class="settings--overlay hidden">
                <button class="button">Edit post</button>

                <form action="app/posts/delete.php?post_id=<?php echo $post['id']; ?>" method="post" class="delete__form">
                    <button type="submit" name="delete" class="delete__button button">Delete post</button>
                </form>
            </div>

            <div class="post__image">
                <img src="uploads/<?php echo $post['image']; ?>" alt="<?php echo $post['description']; ?>" class="post__image <?php echo $post['filter'] ?>" loading="lazy">
            </div>

            <div class="post__information">
                <div class="post__information--holder">
                    <div class="post__likes">
                        <form method="post" class="like__form">
                            <input type="hidden" name="liked-post-id" value="<?php echo $post['id']; ?>">
                            <button type="submit" class="like__button <?php echo (isLiked($pdo, $user['id'], $post['id'])) ? 'like__button--liked' : 'like__button--unliked'; ?>"></button>
                            <p>
                                <?php
                                $likes = getAmountLikes($pdo, $post['id']);
                                echo ($likes[0] > 0) ? "$likes[0] people likes this" : "Nobody has liked this yet";
                                ?>
                            </p>
                        </form>
                    </div>
                    <!--/post__likes-->

                    <div class="post__details--description">
                        <p><?php echo $post['description']; ?></p>
                    </div>
                    <!--/post__description-->

                    <div class="post__details--time">
                        <p><?php echo $post['date']; ?></p>
                    </div>
                </div>

                <?php if ($post['user_id'] === $user['id']) : ?>
                    <div class="post__edit hidden">
                        <form method="post" class="edit__form">
                            <textarea name="description-edit"><?php echo $post['description'] ?></textarea>
                            <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                            <div class=" edit__form--buttons">
                                <div class="edit__form--submit">
                                    <button type="submit" name="save" class="button">Save</button>
                                </div>
                                <p>Cancel</p>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
            <!--/post__information-->
        </div>
        <!--/.post-->
    <?php endforeach; ?>
<?php endif; ?>
