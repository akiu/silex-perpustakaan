<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\Common\BaseAction;

class VoteDigitalBookAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $request = $this->app['request'];

        $session = $this->app['session'];

        $user = $session->get('userId');

        $id = $user['value'];

        $voteResult = $request->request->get("voteResult");

        $slug = $request->request->get('bookSlug');

        $bookId = $conn->fetchAssoc("SELECT id FROM digitalbooks WHERE slug = ?", [$slug]);

        $check = $conn->fetchAssoc(
            "SELECT id FROM Digitalvote WHERE userId = ? AND voteForDigitalBookId = ? ",
            [
                $id,
                $bookId['id']
            ]
        );

        if ($check) {

            $conn->update('Digitalvote',
                [
                    'voteValue' => $voteResult
                ],
                [
                    'userId' => $id,
                    'voteForDigitalBookId' => $bookId['id']
                ]
            );

        } else {
            $conn->insert('Digitalvote',
                [
                    'userId' => $id,
                    'voteForDigitalBookId' => $bookId['id'],
                    'voteValue' => $voteResult
                ]
            );
        }
    }
}