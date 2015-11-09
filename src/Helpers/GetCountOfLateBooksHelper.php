<?php

namespace ExpressLibrary\Helpers;

use ExpressLibrary\Db\Db;

class GetCountOfLateBooksHelper
{
    public static function help()
    {
        $conn = Db::getInstance();

        $conts = $conn->fetchAll("SELECT * FROM lateBooks");

        return count($conts);


    }
}