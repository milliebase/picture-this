<?php require __DIR__ . '/views/header.php';

$user = authenticateUser($pdo);
?>

<section class="create-post">
    <div class="error__text">
        <p><?php showErrors(); ?></p>
    </div>

    <form action="app/posts/store.php" method="post" enctype="multipart/form-data" class="form create-post__form">
        <div class="form__group">
            <input type="file" accept="image/jpeg,image/png" name="post-image" id="post-image" required>
        </div><!-- /form-group -->

        <div class="post__preview">
            <img src="assets/images/empty-image.svg" id="preview" alt="An image placeholder">
        </div>

        <div class="filter__holder hidden">
            <h3>Add a filter</h3>

            <?php $filters = getFilters($pdo); ?>
            <div class="filters">
                <?php foreach ($filters as $filter) : ?>
                    <div class="filter">
                        <p><?php echo $filter['filter_name']; ?></p>
                        <label>
                            <input type="radio" name="filter" value="<?php echo $filter['filter_class']; ?>">
                            <div class="filter__button <?php echo $filter['filter_class']; ?>"></div>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="form__group">
            <label for="description">Add a description</label>
            <textarea name="description" id="description" cols="50" rows="10" placeholder="Write your image text here"></textarea>
        </div><!-- /form-group -->

        <button type="submit" class="button">Share post</button>
    </form>

</section>

<?php require __DIR__ . '/views/footer.php'; ?>
