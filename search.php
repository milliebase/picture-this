<?php require __DIR__ . '/views/header.php';

$user = authenticateUser($pdo);

?>

<section class="search section">

    <form method="post" class="form search__form">
        <div class="form__group">
            <label for="search">Search</label>
            <input type="text" name="search" id="search" required>
        </div><!-- /form-group -->

        <button type="submit" class="button ">Search</button>
    </form>

    <div class="found__users">
    </div>

</section>

<?php require __DIR__ . '/views/footer.php';
