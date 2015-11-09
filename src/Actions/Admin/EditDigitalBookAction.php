<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Common\BaseAction;

class EditDigitalBookAction extends BaseAction
{
    public function handle(
        $bookId,
        $bookImage,
        $bookAttachment,
        $bookTitle,
        $bookCategory,
        $bookAuthor,
        $bookTotalPage,
        $bookDescription,
        $bookImagePath,
        $bookAttachmentPath
    )

    {
        $conn = $this->app['db'];

        $fs = $this->app['fs'];

        $slugify = $this->app['slugify'];


        if (!is_null($bookImage)) {

            $fs->remove($bookImagePath);

            $exts = $bookImage->guessExtension();

            $bookImage->move('images', $slugify->slugify($bookTitle) . "." . $exts);

            $conn->update('digitalbooks',
                [
                    'imagePath' => "images/" . $slugify->slugify($bookTitle) . "." . $exts
                ],
                [
                    'id' => $bookId
                ]
            );
        }

        if (!is_null($bookAttachment)) {

            $fs->remove($bookAttachmentPath);

            $extsAttachment = $bookAttachment->guessExtension();

            $bookAttachment->move('attachments', $slugify->slugify($bookTitle) . "." . $extsAttachment);

            $conn->update('digitalbooks',
                [
                    'attachmentPath' => "attachments/" . $slugify->slugify($bookTitle) . "." . $extsAttachment
                ],
                [
                    'id' => $bookId
                ]
            );
        }

        $conn->update('digitalbooks',
            [
                'title' => $bookTitle,
                'category' => $bookCategory,
                'author' => $bookAuthor,
                'totalPage' => $bookTotalPage,
                'description' => $bookDescription,
                'slug' => $slugify->slugify($bookTitle)
            ],
            [
                'id' => $bookId
            ]
        );


    }
}