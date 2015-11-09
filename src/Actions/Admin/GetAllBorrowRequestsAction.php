<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class GetAllBorrowRequestsAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        //$datas = $conn->fetchAll("SELECT * FROM borrowRequest");

        $qb = $conn->createQueryBuilder()
            ->select("*")
            ->from("borrowRequest");
            //->orderBy('userId', 'asc');

        return $qb;
    }
}
