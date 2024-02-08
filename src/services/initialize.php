<?php

use src\services\Connection;

require_once __DIR__.'/Connection.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/models/books.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/models/user.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/models/coverImages.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/services/checkTable.php';

$pdo = Connection::getPdo();

if (!tableExists($pdo, 'books')) {
    createBooks($pdo);
}

if (!tableExists($pdo, 'user')) {
    createUser($pdo);
}

if (!tableExists($pdo, 'coverimages')) {
    createCoverImages($pdo);
}
