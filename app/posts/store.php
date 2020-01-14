<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we store/insert new posts in the database.
if (isset($_FILES['post-image'])) {
    $user = getUser($pdo, (int) $_SESSION['user']['id']);
    $userId = $user['id'];

    $postImage = $_FILES['post-image'];
    $fileName = $postImage['name'];

    $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING));

    //Only works for this timezone at the moment.
    date_default_timezone_set('Europe/Berlin');
    $date = date('H:i j M, Y');

    handleImageErrors($postImage, 10485760, 'create-post.php');
    unset($_SESSION['errors']);

    $uniqId = uniqid();
    $postImageName = "$uniqId-$fileName";

    move_uploaded_file(
        $postImage['tmp_name'],
        __DIR__ . "/../../uploads/$postImageName"
    );

    if (isset($_POST['filter'])) {
        $filter = trim(filter_var($_POST['filter'], FILTER_SANITIZE_STRING));

        $statement = $pdo->prepare('INSERT INTO posts (user_id, image, description, date, filter)
        VALUES (:user_id, :image, :description, :date, :filter)');

        $statement->execute([
            'user_id' => $userId,
            'image' => $postImageName,
            'description' => $description,
            'date' => $date,
            'filter' => $filter,
        ]);
    } else {
        $statement = $pdo->prepare('INSERT INTO posts (user_id, image, description, date)
        VALUES (:user_id, :image, :description, :date)');

        $statement->execute([
            'user_id' => $userId,
            'image' => $postImageName,
            'description' => $description,
            'date' => $date,
        ]);
    }

    redirect('/profile.php?username=' . $user['username']);
}
