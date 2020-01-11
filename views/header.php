<?php
// Always start by loading the default application setup.
require __DIR__ . '/../app/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">

    <title><?php echo $config['title']; ?></title>

    <link rel="stylesheet" href="https://unpkg.com/sanitize.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Concert+One|Libre+Franklin:100,300,400,600,700,800&display=swap">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/login.css">
    <link rel="stylesheet" href="/assets/styles/register.css">
    <link rel="stylesheet" href="/assets/styles/nav.css">
    <link rel="stylesheet" href="/assets/styles/posts.css">
    <link rel="stylesheet" href="/assets/styles/create-posts.css">
    <link rel="stylesheet" href="/assets/styles/search.css">
    <link rel="stylesheet" href="dist/instagram.css">
</head>

<body>
    <?php require __DIR__ . '/navigation.php'; ?>

    <div class="container">
