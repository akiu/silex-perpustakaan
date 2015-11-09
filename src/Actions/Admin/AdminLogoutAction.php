<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Admin\BaseAction;

class AdminLogoutAction extends BaseAction
{
    public function handle()
    {
        $session = $this->app['session'];

        $session->remove('role');

        $session->remove('adminId');

        $session->getFlashBag()->add('message', 'You are log out now');
    }
}