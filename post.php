<?php require __DIR__ . '/views/header.php';

$user = authenticateUser($pdo);

?>
<section class="section">
    <div class="comments">
    </div>
    <form action="app/posts/store.php" method="post" enctype="multipart/form-data" class="form create-post__form">
        <div class="form__group">
            <label for="comment">Comment</label>
            <textarea name="comment" id="comment-textarea" cols="50" rows="10" placeholder="Write your comment here"></textarea>
        </div><!-- /form-group -->

        <button type="submit" class="button comment-button">Share comment</button>
    </form>
</section>
<script src="/assets/scripts/comments.js"></script>
<?php require __DIR__ . '/views/footer.php';
