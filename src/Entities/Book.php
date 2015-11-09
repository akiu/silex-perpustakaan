<?php

namespace ExpressLibrary\Entities;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

class Book
{
    protected $title;
    protected $category;
    protected $author;
    protected $description;
    protected $totalPage;
    protected $imagePath;
    protected $slug;
    protected $image;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($desc)
    {
        $this->description = $desc;
    }

    public function setCategory($cat)
    {
        $this->category = $cat;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($auth)
    {
        $this->author = $auth;
    }

    public function setTotalPage($page)
    {
        $this->totalPage = $page;
    }

    public function getTotalPage()
    {
        return $this->totalPage;
    }

    public function setImagePath($path)
    {
        $this->imagePath = $path;
    }

    public function getImagePath()
    {
        //return $this->imagePath;
        return $this->getTitle() . uniqid();
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($img)
    {
        $this->image = $img;
    }




}