<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common;

class RejectBorrowRequestAction extends BaseAction
{
    public function handle($requestId)
    {
        $conn = $this->app['db'];

        $borrowRequest = $conn->fetchAssoc("SELECT * FROM borrowRequest WHERE id = ?", [$requestId]);

        $conn->insert('rejectedBookRequest',
            [
                'userId' => $borrowRequest['userId'],
                'userName' => $borrowRequest['userName'],
                'bookId' => $borrowRequest['bookId'],
                'bookTitle' => $borrowRequest['bookTitle'],
                'createdDate' => $borrowRequest['createdDate'],
            ]
        );

        $conn->delete("borrowRequest", ['id' => $requestId]);
    }
}