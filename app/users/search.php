<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['search'])) {
    $search = trim(filter_var($_POST['search'], FILTER_SANITIZE_STRING));

    if (!empty($search)) {
        $search = "%$search%";

        $statement = $pdo->query("SELECT username, first_name, last_name
        FROM users WHERE username LIKE ? OR first_name LIKE ?");

        $statement->execute([$search, $search]);

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $result = "No users";
    }

    header('Content-Type: application/json');

    echo json_encode($result);
}
