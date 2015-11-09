<?php

namespace ExpressLibrary\Actions\Common;

use ExpressLibrary\Actions\Common\BaseAction;

class GetDigitalBookBySlugAction extends BaseAction
{
    public function handle($slug)
    {
        $conn = $this->app['db'];

        $data = $conn->fetchAssoc("SELECT * FROM digitalbooks WHERE slug = ?", [$slug]);

        return $data;
    }
}