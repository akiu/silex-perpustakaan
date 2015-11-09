<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class GetUserProfileAction extends BaseAction
{
    public function handle($userId)
    {
        $conn = $this->app['db'];

        $userProfile = $conn->fetchAssoc("SELECT * FROM userProfile WHERE userId = ?", [$userId]);

        return $userProfile;
    }
}