<?php

namespace ExpressLibrary\Actions\Common;

use ExpressLibrary\Actions\Common\BaseAction;

class GetDigitalVoteCountAction extends BaseAction
{
    public function handle($id)
    {
        $conn = $this->app['db'];

        $data = $conn->fetchAll("SELECT result FROM voteResult WHERE bookId = ?", [$id]);

        return $data;
    }
}