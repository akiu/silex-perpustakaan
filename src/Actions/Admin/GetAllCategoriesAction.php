<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Admin\BaseAction;

class GetAllCategoriesAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $qb = $conn->createQueryBuilder()
            ->select("*")
            ->from("category")
            ->orderBy('name', 'asc');

        $datas = $conn->fetchAll('SELECT * FROM category');

        return $qb;
    }
}