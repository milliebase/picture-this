<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we store/insert new posts in the database.
if (isset($_FILES['post-image'], $_POST['description'])) {
    $userId = $user['id'];

    $postImage = $_FILES['post-image'];
    $fileName = $postImage['name'];
    $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING));

    handleImageErrors($postImage, '10485760', 'create-post.php', 'create-post');
    unset($_SESSION['errors']);

    $uniqId = uniqid();
    $postImageName = "$uniqId-$fileName";

    move_uploaded_file(
        $postImage['tmp_name'],
        __DIR__ . "/../../uploads/$postImageName"
    );

    $statement = $pdo->prepare('INSERT INTO posts (user_id, image, description)
    VALUES (:user_id, :image, :description)');

    $statement->execute([
        'user_id' => $userId,
        'image' => $postImageName,
        'description' => $description,
    ]);

    redirect('/create-post.php');
}
