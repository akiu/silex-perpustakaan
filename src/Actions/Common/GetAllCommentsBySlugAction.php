<?php

namespace ExpressLibrary\Actions\Common;

use ExpressLibrary\Actions\Common\BaseAction;

class GetAllCommentsBySlugAction extends BaseAction
{
    public function handle($id)
    {
        $conn = $this->app['db'];

        $qb = $conn->createQueryBuilder();

        $tableName = "book_comments_" . $id;

        $qb->select("*")
            ->from($tableName)
            ->orderBy("intTime", "ASC");



        //$comments = $conn->fetchAll("SELECT * FROM $tableName");

        return $qb;

    }
}