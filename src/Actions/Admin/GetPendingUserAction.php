<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class GetPendingUserAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $qb = $conn->createQueryBuilder();

        $qb->select("*")
            ->from("user")
            ->where('status = ?')
            ->setParameter(0, "pending");
        //$datas = $conn->fetchAll("SELECT * FROM users WHERE status = ?", ["pending"]);

        return $qb;
    }
}