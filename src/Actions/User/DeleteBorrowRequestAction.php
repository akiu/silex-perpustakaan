<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\Common\BaseAction;

class DeleteBorrowRequestAction extends BaseAction
{
    public function handle($bookId)
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $user = $session->get('userId');

        $userId = $user['value'];

        $conn->delete('borrowRequest', ['bookId' => $bookId, 'userId' => $userId]);
    }
}