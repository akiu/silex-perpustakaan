<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Admin\BaseAction;

class RetrieveCategoryAction extends BaseAction
{
    public function handle($slug = null)
    {
        $conn = $this->app['db'];

        if($slug == null )
        {
            $data = $conn->fetchAll("select * from category");
            return $data;
        } else
        {
            $data = $conn->fetchArray("select * from category where slug = ?", [$slug]);
            return $data;
        }


    }
}