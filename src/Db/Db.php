<?php

namespace ExpressLibrary\Db;

class Db
{
    public static function getInstance()
    {
        return \Doctrine\DBAL\DriverManager::getConnection(
            [
                'dbname' => 'perpus',
                'user' => 'root',
                'password' => 'root',
                'host' => 'localhost',
                'driver' => 'pdo_mysql'],
            new \Doctrine\DBAL\Configuration());
    }
}