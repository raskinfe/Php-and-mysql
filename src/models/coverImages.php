<?php

function createCoverImages(PDO $pdo) {
    $sql = <<<SQL
            CREATE TABLE coverimages (
                id INT AUTO_INCREMENT,
                image varchar(255),
                book_isbn int,
                PRIMARY KEY (id),
                Foreign Key (book_isbn) REFERENCES books(isbn)  ON DELETE CASCADE
            );
        SQL;

    try {
        $pdo->exec($sql);
        return true;
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
    return false;
}