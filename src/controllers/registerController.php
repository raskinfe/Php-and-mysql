<?php

use src\services\Connection;

$error = null;
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$repeat_password = htmlspecialchars($_POST['repeat_password']);

if ($password != $repeat_password) {
    $error = "password doesn't match";
}

if (!$error && $name && $email && $password) {
    require_once $_SERVER['DOCUMENT_ROOT']. '/services/Connection.php';
    $pdo = Connection::getPdo();
    $sql = "INSERT INTO user (name, email, password) VALUES (?,?,?)";
    $stmt= $pdo->prepare($sql);

    try {
        $user = $stmt->execute([$name, $email, $password]);
        if ($user) {
            $success = "Successfully registered";
            echo "<script>";
            echo "
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 2000);
                ";
            echo "</script>";
        } else {
           $error = 'The email address provided is already exist in our database';
        }
    } catch(PDOException $er) {
        $error = $er->getMessage();
    }
}
