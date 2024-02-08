<?php

namespace src\api;

use PDOException;
use src\services\Connection;
require_once $_SERVER['DOCUMENT_ROOT'].'/services/Connection.php';

class ProfileDirectory
{
    public function update()
    {
        $userId = $_SESSION['user']['id'];
        $pdo = Connection::getPdo();

        if (isset($_POST['name'])) {
            $sql = "UPDATE user SET name=:name WHERE id=:id";
            $stmt = $pdo->prepare($sql);

            try {
                if ($stmt->execute(['name'=>$_POST['name'], 'id'=>$userId])) {
                    $user = $_SESSION['user'];
                    $user['name'] = $_POST['name'];
                    $_SESSION['user'] = $user;
                    return http_response_code(204);
                } else {
                    return http_response_code(400);
                }
            } catch (PDOException $exception) {
                $error = $exception->getMessage();
            }
        }
        return http_response_code(400);
    }

    public function destroy() {
        $userId = $_SESSION['user']['id'];
        $pdo = Connection::getPdo();

        $sql = "DELETE FROM user WHERE id=:id";
        $stmt = $pdo->prepare($sql);

        try {
            if ($stmt->execute(['id'=>$userId])) {
                return http_response_code(204);
            } else {
                return http_response_code(400);
            }
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        return http_response_code(400);
    }

    public function getUserByName()
    {
        $user = $_POST['name'];
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM user WHERE name=:name";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute(['name' => $user]);
            $userName = $stmt->fetch();
            if ($userName) {
                header('Content-Type: application/json; charset=utf-8');
                print(json_encode(['response' => $userName]));
            } else {
                return http_response_code(400);
            }
        } catch (PDOException $exception) {
            return http_response_code(400);
        }
    }

    public function updateProfilePicture()
    {
        $user = $_POST['id'];
        $pdo = Connection::getPdo();

        if(isset($_FILES['image']))
        {
            $image = $_FILES['image']['name'];
            $target_dir = "./assets/uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        }

        $sql = "UPDATE user SET avatar=:avatar WHERE id=:id";
        $stmt = $pdo->prepare($sql);

        try{
            if ($stmt->execute(['avatar'=>$image, 'id'=>$user])) {
                return http_response_code(204);
            }
            http_response_code(400);
        } catch(PDOException $exception) {
            http_response_code(400);
        }
    }
}
