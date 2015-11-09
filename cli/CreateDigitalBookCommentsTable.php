<?php

require_once "../vendor/autoload.php";

$conn = ExpressLibrary\Db\Db::getInstance();

$books = $conn->fetchAll("SELECT id FROM digitalbooks");

foreach ($books as $book) {

    $column = $sm->listTableColumns("digital_book_comments_" . $book['id']);

    if (!$column) {

        $tableName = "book_comments_" . $book['id'];

        $sql = "CREATE TABLE $tableName (
            id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userName VARCHAR (255),
            imagePath VARCHAR(255),
            commentContent TEXT,
            intTime INT(255)

        )";

        $stmt = $conn->prepare($sql);

        $stmt->execute();


    }
}
