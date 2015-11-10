<?php

namespace ExpressLibrary\Actions\Common;

use ExpressLibrary\Actions\Common\BaseAction;

class CommentDigitalAction extends BaseAction
{
    public function handle($comment, $id)
    {
        $conn = $this->app['db'];

        $session = $this->app['session'];

        $userId = $session->get('userId');

        $userId = $userId['value'];

        $userName = $conn->fetchAssoc(
            "SELECT username FROM user WHERE id = ?",
            [
                $userId
            ]
        );

        $imagePath = $conn->fetchAssoc(
            "SELECT profilePicturePath FROM userProfile WHERE userId = ?",
            [
                $userId
            ]
        );

        if (!$imagePath) {

            $picture = "images/anon.jpg";

        } else {

            $picture = $imagePath['profilePicturePath'];

        }

        $tableName = "digital_book_comments_" . $id;

        $conn->insert($tableName,
            [
                'userName' => $userName['username'],
                'imagePath' => $picture,
                'commentContent' => $comment,
                'intTime' => date("U")
            ]
        );
    }
}