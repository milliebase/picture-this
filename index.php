<?php require __DIR__ . '/views/header.php';

$user = authenticateUser($pdo);

?>

<article>
    <?php if (isset($_SESSION['user'])) : ?>
        <h1>Welcome, <?php echo $user['first_name']; ?></h1>
    <?php else : ?>
        <h1><?php echo $config['title']; ?></h1>
    <?php endif; ?>
    <p>This is the home page.</p>
</article>

<section class="main__feed">
    <?php $posts = getMainFeedPosts($pdo, $user['id']); ?>

    <?php if (empty($posts)) : ?>
        <p>There are no posts to show yet. Hurry up and post!</p>
    <?php endif; ?>

    <?php require __DIR__ . '/posts.php'; ?>

</section>

<?php require __DIR__ . '/views/footer.php'; ?>
