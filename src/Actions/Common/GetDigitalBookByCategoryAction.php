<?php

namespace ExpressLibrary\Actions\Common;

use ExpressLibrary\Actions\Common\BaseAction;

class GetDigitalBookByCategoryAction extends BaseAction
{
    public function handle($categorySlug)
    {
        $conn = $this->app['db'];

        $categoryId = $conn->fetchAssoc("SELECT id FROM category WHERE slug = ?", [$categorySlug]);



        $qb = $conn->createQueryBuilder();

        $qb->select("*")
            ->from("digitalbooks")
            ->where("category = ?")
            ->orderBy('title', 'ASC')
            ->setParameter(0, $categoryId['id']);

        return $qb;

        //$datas = $conn->fetchAll("SELECT * FROM digitalbooks");
    }
}