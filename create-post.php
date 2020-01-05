<?php require __DIR__ . '/views/header.php'; ?>

<section class="create-posts">

    <h2>Create a new post</h2>

    <div class="preview">
        <img src="assets/images/empty-image.svg" id="preview" alt="An image placeholder">
    </div>

    <form action="app/posts/store.php" method="post" enctype="multipart/form-data" class="form create-post--form">
        <div class="form-group">
            <label for="post-image">Choose an image</label>

            <?php if (isset($_SESSION['errors']['create-post'])) : ?>
                <?php foreach ($_SESSION['errors']['create-post'] as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>

            <input class="form-control" type="file" accept="image/jpeg,image/png" name="post-image" id="post-image" required>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="description">Add a description</label>
            <br>
            <textarea name="description" id="description" cols="50" rows="10" placeholder="Write your image text here"></textarea>
        </div><!-- /form-group -->

        <button type="submit" class="btn btn-primary">Share post</button>
    </form>

</section>

<?php require __DIR__ . '/views/footer.php'; ?>
