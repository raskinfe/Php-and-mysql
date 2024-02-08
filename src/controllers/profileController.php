<?php
use src\services\Connection;

require_once $_SERVER['DOCUMENT_ROOT']. '/services/Connection.php';
$pdo = Connection::getPdo();

$userId = $_SESSION['user']['id'];

if (!$userId) {
    $error = 'User not found';
}

$sql = "SELECT * FROM user WHERE id=:id";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute(['id'=>$userId]);
    $user = $stmt->fetch();
} catch (PDOException $exception) {
    $error = $exception->getMessage();
}


