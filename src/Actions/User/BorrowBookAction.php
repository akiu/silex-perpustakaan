<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\Common\BaseAction;

class BorrowBookAction extends BaseAction
{
    public function handle($slug)
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $userId = $session->get('userId');

        $userId = $userId['value'];

        $book = $conn->fetchAssoc("SELECT * FROM books WHERE slug = ?", [$slug]);

        $user = $conn->fetchAssoc("SELECT * FROM user WHERE id = ?", [$userId]);

        $conn->insert("borrowRequest",
            [
                'bookId' => $book['id'],
                'bookTitle' => $book['title'],
                'userId' => $user['id'],
                'userName' => $user['username'],
                'createdDate' => date("y-m-d")
            ]
        );
    }
}