<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Admin\BaseAction;
use ExpressLibrary\Entities\Category;

class EditCategoryAction extends BaseAction
{
    public function handle(Category $category, $id)
    {
        $conn = $this->app['db'];
        $conn->update('category',
            [
                'name' => $category->getName(),
                'slug' => $category->getSlug()
            ],
            [
                'id' => $id
            ]
        );
    }
}