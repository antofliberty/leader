<?php

namespace Leader\Utils;

use PDO;

class DbConnection
{

    private static DbConnection $instance;


    private string $host = "127.0.0.1";
    private string $db   = 'blockchain_checker';
    private string $user = 'root';
    private string $pass = 'root';
    private string $charset = 'utf8';
    private string $dsn;

    private static PDO $pdo;

    private function __construct()
    {
        $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $this->connect();
    }

    private function connect()
    {
        self::$pdo = new PDO($this->dsn, $this->user, $this->pass);
    }

    public function getPdo(): PDO
    {
        return self::$pdo;
    }

    public static function getInstance(): DbConnection
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}