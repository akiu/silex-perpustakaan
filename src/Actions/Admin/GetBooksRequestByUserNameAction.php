<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class GetBooksRequestByUserNameAction extends BaseAction
{
    public function handle($userName)
    {
        $conn = $this->app['db'];

        $qb = $conn->createQueryBuilder();

         $qb->select("*")
             ->from("borrowRequest")
             ->where("userName = ?")
             ->setParameter(0, $userName);

        return $qb;
    }
}