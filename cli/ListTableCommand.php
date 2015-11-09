<?php

require_once "../vendor/autoload.php";

$conn = ExpressLibrary\Db\Db::getInstance();

$books = $conn->fetchAll("SELECT id FROM books");

$platform = $conn->getDatabasePlatform();

$sm = $conn->getSchemaManager();

$res = 0;

foreach ($books as $book) {

    $column = $sm->listTableColumns("book_comments_" . $book['id']);


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
/*
       $schema = new \Doctrine\DBAL\Schema\Schema();

        $myTable = $schema->createTable("book_comments_" . $book['id']);
        $myTable->addColumn("id", "integer", ["unsigned" => true]);
        $myTable->addColumn("userName", "string", ["limit" => 255]);
        $myTable->addColumn("imagePath", "string", ["limit" => 255]);
        $myTable->addColumn("commentContent", "text");
        $myTable->setPrimaryKey(["id"]);

        $schema->createSequence("book_comments_" . $book['id'] . "_seq");

        $queries = $schema->toSql($platform); // get queries to create this schema.
*/

    }
}
