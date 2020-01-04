<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
    $userId = $user['id'];
    $currentAvatar = $user['avatar'];

    $fileName = $avatar['name'];
    $fileNameArray = explode('.', $fileName);
    $fileEnd = array_pop($fileNameArray);

    //Always be sure to give a user the same name to their avatar image, so it gets overwritten instead of saving each one.
    if ($currentAvatar === null) {
        $uniqId = uniqid();

        $newAvatar = "$uniqId-$userId.$fileEnd";
    } else {
        $currentAvatarArray = explode('.', $currentAvatar);
        $avatarId = $currentAvatarArray[0];
        $newAvatar = "$avatarId.$fileEnd";
    }

    handleImageErrors($avatar, '2097152', 'settings.php');

    move_uploaded_file($avatar['tmp_name'], __DIR__ . "/../../avatars/$newAvatar");

    $statement = $pdo->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');

    $statement->execute([
        ':avatar' => $newAvatar,
        ':id' => $_SESSION['user']['id'],
    ]);

    redirect('/settings.php');
}
