<?php

use src\services\Connection;

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

$error = null;
require_once $_SERVER['DOCUMENT_ROOT']. '/services/Connection.php';
require_once $_SERVER['DOCUMENT_ROOT']. '/services/helper.php';
$pdo = Connection::getPdo();

$sql = "SELECT * FROM user WHERE email=:email";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    if (!$user && $email && $password) {
        $error = 'User not found';
    }

    if (!$error && !checkPassword($password, $user['password']) && $user) {
        $error = 'Wrong password';
    }

    if (!$error && $password && $email) {
        session_start();
        $_SESSION['loggedIn'] = true;
        $_SESSION['user'] = $user;
        setcookie("user", $user['name'], time()+7200);
        header('Location: /');
        exit();
    }
} catch (PDOException $err) {
    $error = $err->getMessage();
}
