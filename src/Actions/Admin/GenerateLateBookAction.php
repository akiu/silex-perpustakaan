<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class GenerateLateBookAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $sql = "TRUNCATE TABLE lateBooks";

        $check = $conn->fetchAll("SELECT * FROM lateBooks");

        if ($check) {

            $stmt = $conn->prepare($sql);

            $stmt->execute();
        }

        $datas = $conn->fetchAll("SELECT * FROM approvedBooksRequest");

        foreach ($datas as $data) {

            $date = strtotime($data['returningDate']);

            $now = date('y-m-d');

            $now = strtotime($now);

            if ( $now > $date )
            {
                $conn->insert('lateBooks',
                    [
                        'userId' => $data['userId'],
                        'userName' => $data['userName'],
                        'bookId' => $data['bookId'],
                        'bookTitle' => $data['bookTitle'],
                        'bookNumber' => $data['bookNumber'],
                        'daysBorrow' => $data['daysBorrow'],
                        'createdDate' => $data['createdDate'],
                        'returningDate' => $data['returningDate'],
                        'status' => "late"
                    ]
                );
            }
        }
    }


}