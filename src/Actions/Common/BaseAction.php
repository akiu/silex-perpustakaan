<?php

namespace ExpressLibrary\Actions\Common;

use Silex\Application;


class BaseAction {

    protected $app;

    public function __construct(Application $app)
    {

        $this->app = $app;
    }
}