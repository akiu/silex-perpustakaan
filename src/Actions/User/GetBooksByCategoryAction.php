<?php

namespace ExpressLibrary\Actions\User;

use ExpressLibrary\Actions\User\BaseAction;

class GetBooksByCategoryAction extends BaseAction
{
    public function handle($categorySlug)
    {
        $conn = $this->app['db'];

        $categoryId = $conn->fetchAssoc("SELECT id FROM category WHERE slug = ?", [$categorySlug]);

        $qb = $conn->createQueryBuilder()
            ->select("*")
            ->from("books")
            ->where("category = ?")
            ->setParameter(0, $categoryId['id']);

        return $qb;
    }
}
