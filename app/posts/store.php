<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we store/insert new posts in the database.
if (isset($_FILES['post-image'], $_POST['description'])) {
    $userId = $user['id'];

    $postImage = $_FILES['post-image'];
    $fileName = $postImage['name'];
    $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING));

    //Only works for this timezone at the moment.
    date_default_timezone_set('Europe/Berlin');
    $date = date('H:i:s - j M, Y');

    handleImageErrors($postImage, '10485760', 'create-post.php', 'create-post');
    unset($_SESSION['errors']);

    $uniqId = uniqid();
    $postImageName = "$uniqId-$fileName";

    move_uploaded_file(
        $postImage['tmp_name'],
        __DIR__ . "/../../uploads/$postImageName"
    );

    $statement = $pdo->prepare('INSERT INTO posts (user_id, image, description, date)
    VALUES (:user_id, :image, :description, :date)');

    $statement->execute([
        'user_id' => $userId,
        'image' => $postImageName,
        'description' => $description,
        ':date' => $date,
    ]);

    redirect('/profile.php');
}
