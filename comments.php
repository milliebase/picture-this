<?php require __DIR__ . '/views/header.php';

$user = authenticateUser($pdo);

?>

<div class="found__users">
    <p><?php echo $_GET['id']; ?></p>
</div>
<script src="/assets/scripts/comments.js"></script>

<?php require __DIR__ . '/views/footer.php';
