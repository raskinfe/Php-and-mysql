<?php

function createBooks(PDO $pdo): bool
{
    $sql = <<<SQL
                CREATE TABLE books (
                    id int NOT NULL AUTO_INCREMENT,
                    title varchar(255) NOT NULL unique,
                    author varchar(255) NOT NULL,
                    isbn int NOT NULL UNIQUE,
                    published_year date NOT NULL,
                    created_by int NOT NULL,
                    borrowed_by int,
                    category varchar(255) NOT NULL,
                    created_at datetime,
                    status varchar(255) DEFAULT 'active',
                    PRIMARY KEY (id),
                    FOREIGN KEY (created_by) REFERENCES user(id) ON DELETE CASCADE,
                    FOREIGN KEY (borrowed_by) REFERENCES user(id) ON DELETE CASCADE
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
