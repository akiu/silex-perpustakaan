<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Admin\BaseAction;
use ExpressLibrary\Entities\Category;

class AddCategoryAction extends BaseAction
{
    public function handle(Category $category)
    {
        $conn = $this->app['db'];

        $slugify = $this->app['slugify'];

        $category->setSlug($slugify->slugify($category->getName()));

        $conn->insert('category',
            [
                'name' => $category->getName(),
                'slug' => $category->getSlug()
            ]
        );
    }
}