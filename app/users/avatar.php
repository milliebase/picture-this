<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_FILES['avatar'])) {
    $user = getUser($pdo, (int) $_SESSION['user']['id']);

    $avatar = $_FILES['avatar'];
    $userId = $user['id'];
    $currentAvatar = $user['avatar'];

    $newFileName = $avatar['name'];
    $newFileNameArray = explode('.', $newFileName);
    $newFileEnd = array_pop($newFileNameArray);

    //Always be sure to give a user the same name to their avatar image, so it gets overwritten instead of saving each one.
    if ($currentAvatar === null) {
        $uniqId = uniqid();
        $newAvatar = "$uniqId-$userId.$newFileEnd";
    } else {
        $currentAvatarArray = explode('.', $currentAvatar);
        $avatarId = $currentAvatarArray[0];
        $newAvatar = "$avatarId.$newFileEnd";
    }

    if ($avatar['type'] !== 'image/png' && $avatar['type'] !== 'image/jpeg') {
        $message = ['error' => 'The filetype must be a .jpg, .jpeg or .png.'];

        header('Content-Type: application/json');
        echo json_encode($message);
        exit;
    }

    if ($avatar['size'] >= 2097152) {
        $message = ['error' => 'The file can\'t exceed 2 MB.'];

        header('Content-Type: application/json');
        echo json_encode($message);
        exit;
    }

    if ($currentAvatar !== null) {
        unlink(__DIR__ . "/../../uploads/avatars/$currentAvatar");
    }

    move_uploaded_file($avatar['tmp_name'], __DIR__ . "/../../uploads/avatars/$newAvatar");

    $statement = $pdo->prepare('UPDATE users SET avatar = ? WHERE id = ?');

    $statement->execute([$newAvatar, $userId]);

    $message = ['success' => 'Your profile picture is updated.'];

    header('Content-Type: application/json');
    echo json_encode($message);
}
