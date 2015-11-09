<?php

namespace ExpressLibrary\Helpers;

use ExpressLibrary\Db\Db;

class GetAllCategoriesHelper
{
    public static function help($mode = 0)
    {
        $conn = Db::getInstance();

        $conts = $conn->fetchAll("SELECT * FROM category");

        $datas = [];

        switch ($mode)
        {
            case 0;
                foreach ($conts as $cont)
                {
                    $datas[] = [$cont['id'] => $cont['name']];
                }

                return $datas;

            case 1;
                foreach ($conts as $cont)
                {
                    $datas[] = $cont['slug'];
                }

                return $datas;

            case 2;

                return $conts;

        }


    }
}