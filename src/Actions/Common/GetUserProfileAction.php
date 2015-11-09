<?php

namespace ExpressLibrary\Actions\Common;

use ExpressLibrary\Actions\Common\BaseAction;

class GetUserProfileAction extends BaseAction
{
    public function handle()
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $userId = $session->get('userId');

        $userProfile = $conn->fetchAssoc("SELECT * FROM userProfile where userId = ?", [$userId['value']]);

        return $userProfile;
    }
}