<?php

namespace ExpressLibrary\Entities;

class DigitalBook
{
    protected $title;
    protected $category;
    protected $description;
    protected $author;
    protected $totalPage;
    protected $slug;
    protected $attachment;
    protected $attachmentPath;
    protected $image;
    protected $imagePath;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($desc)
    {
        $this->description = $desc;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getTotalPage()
    {
        return $this->totalPage;
    }

    public function setTotalPage($total)
    {
        $this->totalPage = $total;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getAttachment()
    {
        return $this->attachment;
    }

    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
    }

    public function getAttachmentPath()
    {
        //return $this->attachmentPath;
        return $this->getTitle() . uniqid();
    }

    public function setAttachmentPath($attachment)
    {
        $this->attachmentPath = $attachment;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($img)
    {
        $this->image = $img;
    }

    public function getImagePath()
    {
        //return $this->imagePath;
        return $this->getTitle() . uniqid();

    }

    public function setImagePath($imgPath)
    {
        $this->imagePath = $imgPath;
    }
}