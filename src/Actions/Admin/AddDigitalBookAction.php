<?php

namespace ExpressLibrary\Actions\Admin;

use ExpressLibrary\Actions\Admin\BaseAction;
use ExpressLibrary\Entities\DigitalBook;

class AddDigitalBookAction extends BaseAction
{
    public function handle(DigitalBook $digitalBook)
    {
        //db connection

        $conn = $this->app['db'];

        //upload image

        $image = $digitalBook->getImage();

        $imageName = $digitalBook->getImagePath();

        $imageExts = $image->guessExtension();

        $image->move('images', $imageName . "." . $imageExts);

        //upload attachment

        $attachment = $digitalBook->getAttachment();

        $attachmentName = $digitalBook->getAttachmentPath();

        $attachmentExts = $attachment->guessExtension();

        $attachment->move('attachments', $attachmentName . "." . $attachmentExts);

        //save data to database

        $conn->insert('digitalbooks',
            [
                'title' => $digitalBook->getTitle(),
                'category' => $digitalBook->getCategory(),
                'author' => $digitalBook->getAuthor(),
                'totalPage' => $digitalBook->getTotalPage(),
                'description' => $digitalBook->getDescription(),
                'slug' => $digitalBook->getSlug(),
                'imagePath' => "images/" . $imageName . "." . $imageExts,
                'attachmentPath' => "attachments/" . $attachmentName . "." . $attachmentExts
            ]
        );
    }
}