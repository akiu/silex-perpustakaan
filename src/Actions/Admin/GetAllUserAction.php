<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class GetAllUserAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $qb = $conn->createQueryBuilder()
            ->select("*")
            ->from("user")
            ->orderBy('username', 'asc');

        return $qb;
    }
}