<?php

namespace ExpressLibrary\Entities;

class Category
{
    protected $name;
    protected $slug;

    public function getName()
    {
        return $this->name;
    }

    public function setName($nama)
    {
        $this->name = $nama;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
}