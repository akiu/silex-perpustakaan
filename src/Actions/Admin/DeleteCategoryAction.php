<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Admin\BaseAction;

class DeleteCategoryAction extends BaseAction
{
    public function handle($slug)
    {
        $conn = $this->app['db'];
        $conn->delete('category', array(
            'slug' => $slug)
        );

    }
}