<?php
namespace ExpressLibrary\Actions\User;

/**
 * Created by PhpStorm.
 * User: akiujih
 * Date: 16/10/15
 * Time: 12:52
 */

use ExpressLibrary\Actions\User\BaseAction;
use ExpressLibrary\Entities\User;
use Silex\Application;


class LoginAction extends BaseAction
{

    public function handle(User $user)
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $loggedUser = $conn->fetchAssoc('SELECT * FROM user WHERE username = ? AND status = ?',
            [$user->getUsername(), "active"]);

        if(count($loggedUser) > 0) {

            $passCheck = password_verify($user->getPassword(), $loggedUser['password']);

            if($passCheck) {

                $session->set('role', ['value' => 'user']);
                $session->set('userId', ['value' => $loggedUser['id']]);

                return true;

            } else

                return false;

        } else {

            return false;
        }
    }
}