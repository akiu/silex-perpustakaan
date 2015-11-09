<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\Common\BaseAction;

class LogoutAction extends BaseAction
{
    public function handle()
    {
        $session = $this->app['session'];

        $session->remove('role');

        $session->remove('userId');

    }
}