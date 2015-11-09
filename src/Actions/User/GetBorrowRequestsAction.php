<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\Common\BaseAction;

class GetBorrowRequestsAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $user = $session->get('userId');

        $userId = $user['value'];

        $datas = $conn->fetchAll("SELECT * FROM borrowRequest WHERE userId = ?", [$userId]);

        return $datas;
    }
}