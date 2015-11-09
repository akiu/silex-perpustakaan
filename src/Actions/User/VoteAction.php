<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\Common\BaseAction;

class VoteAction extends BaseAction
{
    public function handle($slug, $voteResult)
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $user = $session->get('userId');

        $id = $user['value'];

        $bookId = $conn->fetchAssoc("SELECT id FROM books WHERE slug = ?", [$slug]);

        $check = $conn->fetchAssoc(
            "SELECT id FROM vote WHERE userId = ? AND voteForBookId = ? ",
            [
                $id,
                $bookId['id']
            ]
        );

        if ($check) {

            $conn->update('vote',
                [
                    'voteValue' => $voteResult
                ],
                [
                    'userId' => $id,
                    'voteForBookId' => $bookId['id']
                ]
            );

        } else
        {
            $conn->insert('vote',
                [
                    'userId' => $id,
                    'voteForBookId' => $bookId['id'],
                    'voteValue' => $voteResult
                ]
            );
        }
    }
}