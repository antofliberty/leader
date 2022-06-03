<?php

namespace Leader\Traits;

use PDO;
use Leader\Utils\DbConnection;

trait PdoTrait
{
    private static PDO $pdo;

    public static function init()
    {
        self::$pdo = DbConnection::getInstance()->getPdo();
    }

}