<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <?php if (isset($_SESSION['user'])) : ?>
        <h1><?php echo 'Welcome, ' . $_SESSION['user']['name']; ?></h1>
    <?php else : ?>
        <h1><?php echo $config['title']; ?></h1>
    <?php endif; ?>
    <p>This is the home page.</p>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
