<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\Common\BaseAction;

class GetAllBorrowingBooksAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $user = $session->get('userId');

        $userId = $user['value'];

        $borrowingBooks = $conn->fetchAll('SELECT * FROM approvedBooksRequest WHERE userId = ?', [$userId]);

        return $borrowingBooks;
    }
}