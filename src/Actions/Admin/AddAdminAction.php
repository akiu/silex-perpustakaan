<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;
use ExpressLibrary\Entities\Admin;

class AddAdminAction extends BaseAction
{
    public function handle(Admin $admin)
    {
        $conn = $this->app['db'];

        $password = password_hash($admin->getPassword(), PASSWORD_DEFAULT);

        $conn->insert('admin',
            [
                'username' => $admin->getUserName(),
                'password' => $password,
                'email' => $admin->getEmail()
            ]
        );
    }
}