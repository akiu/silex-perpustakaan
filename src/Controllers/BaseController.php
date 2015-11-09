<?php

namespace ExpressLibrary\Controllers;

use Silex\Application;

/**
 * Class BaseController
 * @package ExpressLibrary\Controllers
 */
class BaseController
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
