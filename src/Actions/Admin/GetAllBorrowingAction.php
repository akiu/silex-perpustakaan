<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class GetAllBorrowingAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        //$datas = $conn->fetchAll("SELECT * FROM approvedBooksRequest");

        $qb = $conn->createQueryBuilder()
            ->select("*")
            ->from("approvedBooksRequest");
        //->orderBy('userName', 'asc');

        return $qb;
    }
}