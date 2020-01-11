<?php require __DIR__ . '/views/header.php';

$user = authenticateUser($pdo);

?>

<section class="main__feed">
    <?php $posts = getMainFeedPosts($pdo, $user['id']); ?>

    <?php if (empty($posts)) : ?>
        <div class="posts__empty">
            <p>There are no posts to show yet.</p>
            <p>Post your own content</p>
            <p>and start to follow your friends.</p>
        </div>
    <?php endif; ?>

    <?php require __DIR__ . '/posts.php'; ?>

</section>

<?php require __DIR__ . '/views/footer.php'; ?>
