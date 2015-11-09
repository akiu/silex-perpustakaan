<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common;

class ApproveBorrowRequestAction extends BaseAction
{
    public function handle($requestId, $numOfDays, $numOfBooks)
    {
        $conn = $this->app['db'];

        $borrowRequest = $conn->fetchAssoc("SELECT * FROM borrowRequest WHERE id = ?", [$requestId]);

        $returnDate = $borrowRequest['createdDate'];

        $numDays = (string) $numOfDays;

        $returnDate = str_replace('-', '/', $returnDate);

        $returnDate = date('Y-m-d',strtotime($returnDate . "+" . $numDays .  "days"));


        $conn->insert('approvedBooksRequest',
            [
                'userId' => $borrowRequest['userId'],
                'userName' => $borrowRequest['userName'],
                'bookId' => $borrowRequest['bookId'],
                'bookTitle' => $borrowRequest['bookTitle'],
                'bookNumber' => $numOfBooks,
                'daysBorrow' => $numOfDays,
                'createdDate' => $borrowRequest['createdDate'],
                'returningDate' => $returnDate
            ]
        );

        $conn->delete("borrowRequest", ['id' => $requestId]);
    }
}