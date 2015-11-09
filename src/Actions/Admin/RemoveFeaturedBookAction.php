<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class RemoveFeaturedBookAction extends BaseAction
{
    public function handle($slug)
    {
        $conn = $this->app['db'];

        $conn->delete('featuredBooks', ['slug' => $slug]);
    }
}
