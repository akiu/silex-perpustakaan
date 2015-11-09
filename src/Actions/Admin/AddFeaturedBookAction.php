<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Admin\BaseAction;

class AddFeaturedBookAction extends BaseAction
{
    public function handle($slug)
    {
        $conn = $this->app['db'];

        $toBeAdded = $conn->fetchAssoc("SELECT * FROM books WHERE slug = ?", [$slug]);

        $conn->insert('featuredBooks',
            [
                'title' => $toBeAdded['title'],
                'slug' => $toBeAdded['slug'],
                'author' => $toBeAdded['author'],
                'imagePath' => $toBeAdded['imagePath']
            ]
        );
    }
}