<?php

namespace src\api;

session_start();

use PDO;
use PDOException;
use src\services\Connection;

require_once $_SERVER['DOCUMENT_ROOT'].'/services/Connection.php';

class OffersController
{
    public function index() {
        $pdo = Connection::getPdo();

        $sql = <<<SQL
                    SELECT books.id, books.title, books.author, books.published_year, books.status, coverimages.image, books.isbn, books.borrowed_by, user.name
                    FROM coverimages 
                    inner JOIN books ON coverimages.book_isbn=books.isbn
                    inner join user ON books.created_by=user.id;
                SQL;

        return $this->extracted($pdo, $sql);
    }

    public function getBookByCategory()
    {
        $pdo = Connection::getPdo();
        $categories = $_GET['categories'];
        $categories = explode(',', $categories);
        $placeholders = str_repeat ('?, ',  count ($categories) - 1) . '?';
        $sql = <<<SQL
                    SELECT books.id, title, author, published_year, status, image, isbn, borrowed_by, user.name
                    FROM books 
                    inner join user ON books.created_by=user.id
                    WHERE books.category IN($placeholders);
                SQL;

        return $this->extracted($pdo, $sql, $categories);
    }

    public function store() {
        $pdo = Connection::getPdo();

        $title = htmlspecialchars($_POST['title']);
        $author = htmlspecialchars($_POST['author']);
        $isbn = htmlspecialchars($_POST['isbn']);
        $published_year = htmlspecialchars($_POST['published_year']);
        $category = htmlspecialchars($_POST['category']);
        $created_by = intval($_SESSION['user']['id']);
        $created_at = date("Y-m-d H:i:s");
        $image = $this->getStr();


        $data = array($title, $author, $isbn, $published_year, $category, $created_by, $created_at);

        $sql = "INSERT INTO books(title, author, isbn, published_year, category, created_by, created_at) values(?,?,?,?,?,?,?)";
        $image_sql = "INSERT INTO coverimages(image, book_isbn) values(?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt_images = $pdo->prepare($image_sql);
        try {
            if ($stmt->execute($data) && $stmt_images->execute([$image, $isbn])) {
                return http_response_code(204);
            } else {
                echo "this message";
                return http_response_code(400);
            }

        } catch (PDOException $err) {
            header($err->getMessage());
            echo $err->getMessage();
            return http_response_code(400);
        }
    }

    public function getBooksByUser() {
        $user = $_SESSION['user']['id'];
        $pdo = Connection::getPdo();

        $sql = "SELECT * from books where created_by=:created_by";
        return $this->extracted($pdo, $sql, ['created_by'=>$user]);
    }

    /**
     * @param PDO $pdo
     * @param string $sql
     * @return bool|int|void
     */
    public function extracted(PDO $pdo, string $sql, $variables=[])
    {
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute($variables);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: application/json; charset=utf-8');
            print(json_encode(['response' => $books]));
        } catch (PDOException $exception) {
            return http_send_data($exception->getMessage());
        }
    }

    public function destroy() {
        $pdo = Connection::getPdo();
        $id = intval($_GET['id']);

        $sql = "DELETE FROM books WHERE id=?";
        $stmt = $pdo->prepare($sql);

        try {
            if ($stmt->execute([$id])) {
                return http_response_code(204);
            } else {
                return http_response_code(400);
            }
        } catch (PDOException $exception) {
            print(json_encode(['response' =>  $exception->getMessage()]));
            return http_response_code(400);
        }
    }

    public function updateBook() {
        $pdo = Connection::getPdo();
        $id = $_POST['id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];

        $sql = "UPDATE books SET title=:title, author=:author, isbn=:isbn WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        try {
            if($stmt->execute(['id'=>$id, 'title'=>$title, 'author'=>$author, 'isbn'=>$isbn])){
               echo http_response_code(204);
            }
            echo http_response_code(400);
        } catch(PDOException $exception) {
            echo $exception->getMessage();
            echo http_response_code(400);
        }
    }

    public function updateBookCover() {
        $pdo = Connection::getPdo();
        $isbn = $_POST['isbn'];
        $image = $this->getStr();
        $sql = "UPDATE coverimages SET image=:image WHERE book_isbn=:isbn";
        $stmt = $pdo->prepare($sql);
        try{
            if($stmt->execute(['image' => $image, 'isbn' => $isbn])) {
                echo http_response_code(204);
            }
            echo http_response_code(400);
        }catch (PDOException $except){
            echo $except->getMessage();
            echo http_response_code(204);
        }
    }

    /**
     * @return mixed|string
     */
    public function getStr()
    {
        $image = '';
        if (isset($_FILES['image'])) {
            $image = $_FILES['image']['name'];
            $target_dir = "./assets/uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        }
        return $image;
    }
}
