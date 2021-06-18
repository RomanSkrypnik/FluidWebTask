<?php

namespace Core;


class Model{
    private static $pdo;

    public function __construct()
    {
        if (!self::$pdo) {
            self::$pdo = new \PDO('mysql:host=localhost;dbname=shortlinks', DB_USER, DB_PASS);
            self::$pdo->query("SET NAMES 'utf8'");
        }
    }

    protected function findMany($query){
        $data = self::$pdo->query($query);
        return $data;
    }

    protected function deleteData($query){
        self::$pdo->query($query);
    }
}
