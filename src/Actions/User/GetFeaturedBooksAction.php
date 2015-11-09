<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\User\BaseAction;

class GetFeaturedBooksAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $qb = $conn->createQueryBuilder()
                    ->select("*")
                    ->from("featuredBooks")
                    ->orderBy('title', 'asc');

        //$datas = $conn->fetchAll("SELECT * FROM featuredBooks");

        return $qb;
    }
}