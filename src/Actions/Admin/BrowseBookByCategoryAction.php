<?php

namespace ExpressLibrary\Actions\Admin;


use ExpressLibrary\Actions\Admin\BaseAction;

class BrowseBookByCategoryAction extends BaseAction
{
    public function handle($category)
    {
        $conn = $this->app['db'];

        $cat = $conn->fetchArray("SELECT id FROM category WHERE slug = ?", [$category]);

        $books = $conn->fetchAll('SELECT * from books WHERE category = ?', [$cat[0]]);

        return $books;
    }
}