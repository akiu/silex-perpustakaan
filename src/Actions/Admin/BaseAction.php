<?php

namespace ExpressLibrary\Actions\Admin;

/**
 * Created by PhpStorm.
 * User: akiujih
 * Date: 16/10/15
 * Time: 14:24
 */

use Silex\Application;


class BaseAction {

    protected $app;

    public function __construct(Application $app)
    {

        $this->app = $app;
    }
}