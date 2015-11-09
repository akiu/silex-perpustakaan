<?php

namespace ExpressLibrary\Middlewares;

use ExpressLibrary\Middlewares\BaseMiddleware;

class AdminAuthorizationMiddleware extends BaseMiddleware
{
    public function authorize()
    {
        $role = $this->app['session']->get('role');

        if(!isset($role['value']) || $role['value'] != "admin") {

            $this->app['session']->getFlashBag()->add('message', 'To do administration tasks you must login first');


            return $this->app->redirect($this->app["url_generator"]->generate("adminlogin"));

        }
    }
}