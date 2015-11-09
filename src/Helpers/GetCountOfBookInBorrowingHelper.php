<?php

namespace ExpressLibrary\Helpers;

use ExpressLibrary\Db\Db;

class GetCountOfBookInBorrowingHelper
{
    public static function help()
    {
        $conn = Db::getInstance();

        $count = $conn->fetchAll("SELECT * FROM approvedBooksRequest");

        return count($count);


    }
}