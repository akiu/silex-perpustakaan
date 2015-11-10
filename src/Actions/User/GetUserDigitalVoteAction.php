<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\Common\BaseAction;

class GetUserDigitalVoteAction extends BaseAction
{
    public function handle($id)
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $user = $session->get('userId');

        $uid = $user['value'];

        $data = $conn->fetchAssoc("SELECT voteValue FROM Digitalvote WHERE userId = ? AND voteForDigitalBookId = ?", [$uid, $id]);

        return $data;
    }
}