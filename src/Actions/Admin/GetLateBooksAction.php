<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class GetLateBooksAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $qb = $conn->createQueryBuilder();

        $qb->select("*")
            ->from("lateBooks")
            ->orderBy('createdDate', 'asc');

        return $qb;
    }
}