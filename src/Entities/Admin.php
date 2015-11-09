<?php

namespace ExpressLibrary\Entities;

class Admin
{
    protected $userName;
    protected $password;
    protected $email;

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($uname)
    {
        $this->userName = $uname;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($pass)
    {
        $this->password = $pass;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($em)
    {
        $this->email = $em;
    }
}