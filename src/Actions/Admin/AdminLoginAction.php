<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;
use ExpressLibrary\Entities\Admin;

class AdminLoginAction extends BaseAction
{
    public function handle(Admin $admin)
    {
        $conn = $this->app['db'];
        $session = $this->app['session'];

        $loggedAdmin = $conn->fetchAssoc("SELECT * FROM admin WHERE username = ?", [$admin->getUserName()]);

        if ($loggedAdmin)
        {
            $checkPassword = password_verify($admin->getPassword(), $loggedAdmin['password']);

            if ( $checkPassword )
            {
                $session->set('role', ['value' => "admin"]);
                $session->set('adminId', ['value' => $loggedAdmin['id']]);

                return true;
            }
            else
            {
                $session->getFlashBag()->add('message', 'Your Password is invalid');
                return false;
            }
        }
        else
        {
            $session->getFlashBag()->add('message', 'Maybe your username or password are invalid');
            return false;
        }
    }
}