<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class EditBookBySlugAction extends BaseAction
{
    public function handle($bookId,
                           $oriBookImagePath,
                           $bookTitle,
                           $bookCategory,
                           $bookAuthor,
                           $bookDescription,
                           $bookTotalPage,
                           $bookImage
    )
    {

        $fs = $this->app['fs'];

        $slugify = $this->app['slugify'];

        $conn = $this->app['db'];


        if (!is_null($bookImage)) {

             $fs->remove($oriBookImagePath);

             $exts = $bookImage->guessExtension();

             $bookImage->move("images", $slugify->slugify($bookTitle) . "." . $exts);

             $conn->update('books',
                 [
                     'imagePath' => "images/" . $slugify->slugify($bookTitle) . "." . $exts
                 ],
                 [
                     'id' => $bookId
                 ]
             );
        }

        $conn->update('books',
            [
                'title' => $bookTitle,
                'category' => $bookCategory,
                'slug' => $slugify->slugify($bookTitle),
                'author' => $bookAuthor,
                'totalPage' => $bookTotalPage,
                'description' => $bookDescription,

            ],
            [
                'id' => $bookId
            ]
        );
    }
}