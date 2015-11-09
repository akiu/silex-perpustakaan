<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Admin\BaseAction;
use ExpressLibrary\Entities\Book;

class AddBookAction extends BaseAction
{

    //bertugas untuk mengupload gambar dan save data ke database

    public function handle(Book $book)
    {
        $conn = $this->app['db'];

        $slugify = $this->app['slugify'];

        $session = $this->app['session'];

        //upload image
        $book->setSlug($slugify->slugify($book->getTitle()));

        $image = $book->getImage();


        $exts = $image->guessExtension();

        $imageName = $book->getSlug();

        //uploading image
        $image->move('images', $imageName . '.' . $exts);

        $conn->insert('books',
            [
                'title' => $book->getTitle(),
                'category' => $book->getCategory(),
                'author' => $book->getAuthor(),
                'totalPage' => $book->getTotalPage(),
                'description' => $book->getDescription(),
                'slug' => $book->getSlug(),
                'imagePath' => "images/" . $imageName . '.' . $exts
            ]
        );

        $session->getFlashBag()->add('add-success-message', $book->getTitle());
        $session->getFlashBag()->add('add-success-message', $book->getSlug());

    }
}