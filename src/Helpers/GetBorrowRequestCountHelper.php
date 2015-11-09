<?php

namespace ExpressLibrary\Helpers;

use ExpressLibrary\Db\Db;

class GetBorrowRequestCountHelper
{
    public static function help()
    {
        $conn = Db::getInstance();

        $conts = $conn->fetchAll("SELECT * FROM borrowRequest");

        return count($conts);


    }
}