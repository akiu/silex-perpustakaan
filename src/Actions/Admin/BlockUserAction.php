<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class BlockUserAction extends BaseAction
{
    public function handle($id)
    {
        $conn = $this->app['db'];

        $conn->update('user', ['status' => "banned"], ['id' => $id]);
    }
}