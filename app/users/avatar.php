<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_FILES['avatar'])) {
    $user = fetchUser($pdo, $_SESSION['user']['id']);

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

    handleImageErrors($avatar, '2097152', 'settings.php', 'avatar');

    unlink(__DIR__ . "/../../avatars/$currentAvatar");

    move_uploaded_file($avatar['tmp_name'], __DIR__ . "/../../avatars/$newAvatar");

    $statement = $pdo->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');

    $statement->execute([
        ':avatar' => $newAvatar,
        ':id' => $_SESSION['user']['id'],
    ]);

    redirect('/settings.php');
}
