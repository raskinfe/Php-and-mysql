<?php

function createUser(PDO $pdo): bool
{
    $sql = <<<SQL
                CREATE TABLE user (
                    id int NOT NULL AUTO_INCREMENT,
                    name varchar(255) NOT NULL,
                    email varchar(255) UNIQUE NOT NULL,
                    password varchar(255) NOT NULL,
                    avatar  mediumblob,
                    PRIMARY KEY (id)
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
