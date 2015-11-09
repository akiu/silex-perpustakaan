<?php

namespace ExpressLibrary\Middlewares;

use Silex\Application;

class BaseMiddleware {

	public $app;

    public $message;

	public function __construct(Application $app, $message = "Please login first") {
		$this->app = $app;

        $this->message = $message;
	} 

}