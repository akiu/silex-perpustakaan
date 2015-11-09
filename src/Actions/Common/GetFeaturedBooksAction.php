<?php

namespace ExpressLibrary\Actions\Common;

use ExpressLibrary\Actions\Common\BaseAction;

class GetFeaturedBooksAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $qb = $conn->createQueryBuilder()
            ->select("*")
            ->from("featuredBooks")
            ->orderBy('title', 'asc');

        return $qb;
    }
}