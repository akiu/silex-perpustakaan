<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class GetAllAdminAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $qb = $conn->createQueryBuilder();

        $qb->select("*")
            ->from("admin")
            ->orderBy("username", "asc");

        return $qb;
    }
}