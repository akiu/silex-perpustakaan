<?php

namespace ExpressLibrary\Actions\Common;

use ExpressLibrary\Actions\Common\BaseAction;

class GetBookBySlugAction extends BaseAction
{
    public function handle($slug)
    {
        $conn = $this->app['db'];

        $book = $conn->fetchAssoc('SELECT * FROM books WHERE slug = ?', [$slug]);

        return $book;
    }
}