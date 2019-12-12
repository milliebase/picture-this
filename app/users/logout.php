<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we logout users.
$_SESSION['user'] = [];
session_destroy();

redirect('/');
