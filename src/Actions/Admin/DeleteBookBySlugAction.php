<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Admin\BaseAction;

class DeleteBookBySlugAction extends BaseAction
{
    public function handle($slug)
    {
        $conn = $this->app['db'];
        $fs = $this->app['fs'];

        $data = $conn->fetchAssoc("SELECT * FROM books WHERE slug = ?", [$slug]);


        try {

            $fs->remove($data['imagePath']);

        } catch (Symfony\Component\Filesystem\Exception\IOExceptionInterface $e)
        {
            echo "An error occured when deleting image";
        }


        $conn->delete("books", ['slug' => $slug]);
    }
}