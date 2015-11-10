<?php

namespace ExpressLibrary\Actions\Common;

use ExpressLibrary\Actions\Common\BaseAction;

class GetAllDigitalBookCommentBySlugAction extends BaseAction
{
    public function handle($id)
    {
        $conn = $this->app['db'];

        $qb = $conn->createQueryBuilder();

        $tableName = "digital_book_comments_" . $id;

        $qb->select("*")
            ->from($tableName)
            ->orderBy("intTime", "ASC");

        return $qb;

    }
}