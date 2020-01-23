<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['search'])) {
    $search = trim(filter_var($_POST['search'], FILTER_SANITIZE_STRING));

    if (!empty($search)) {
        $search = "%$search%";

        $statement = $pdo->query("SELECT username, (first_name || \" \" || last_name) AS name, avatar
        FROM users WHERE username LIKE ? OR name LIKE ? LIMIT 15");

        $statement->execute([$search, $search]);

        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        $query = "SELECT * FROM posts WHERE description LIKE :search";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':search', $search, PDO::PARAM_STR);
        $statement->execute();

        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

        $result = [];

        $result[] = [
            'users' => $users,
            'posts' => $posts
        ];
    }

    header('Content-Type: application/json');

    echo json_encode($result);
}
