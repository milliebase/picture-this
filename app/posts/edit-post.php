<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['id'], $_POST['position'])) {
    $id = $_POST['id'];
    $position = $_POST['position'];

    $allPosts = getImagePosts($pdo, $_SESSION['user']['id']);

    $post = json_encode($allPosts[$position]);


    header('Content-Type: application/json');

    echo $post;
}
