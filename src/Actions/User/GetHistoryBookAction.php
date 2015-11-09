<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\Common\BaseAction;

class GetHistoryBookAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $user = $session->get('userId');

        $userId = $user['value'];

        $qb = $conn->createQueryBuilder();

        $qb->select("*")
            ->from("historyBooks")
            ->where("userId = ?" )
            ->setParameter(0, $userId)
            ->orderBy('startDate', 'asc');

        return $qb;
    }
}