<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class ReturnBorrowingBookAction extends BaseAction
{
    public function handle($userId, $bookId)
    {
        $conn = $this->app['db'];

        $book = $conn->fetchAssoc(
            "SELECT * FROM approvedBooksRequest WHERE userId = ? AND bookId = ?",
            [$userId, $bookId]);

        $returnStatus = "";

        $returnDate = strtotime($book['returningDate']);

        if (strtotime("now") > $returnDate) {

            $returnStatus = "late";

        } else {

            $returnStatus = "onTime";

        }

        $conn->insert('historyBooks',
            [
                'userId' => $userId,
                'userName' => $book['userName'],
                'bookId' => $bookId,
                'bookTitle' => $book['bookTitle'],
                'bookNUmber' => $book['bookNumber'],
                'daysBorrow' => $book['daysBorrow'],
                'startDate' => $book['createdDate'],
                'returningDate' => $book['returningDate'],
                'status' => $returnStatus
            ]
        );

        $conn->delete('approvedBooksRequest', ['userId' => $userId, 'bookId' => $bookId]);
    }


}
