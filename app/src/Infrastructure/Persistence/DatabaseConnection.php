<?php

namespace App\Infrastructure\Persistence;

use App\Loaders\SecretsManager;
use \PDO;

class DatabaseConnection
{
    static function connect(
        SecretsManager $secrets
    ): PDO {
        $host = $secrets->secrets['db']['host'];
        $user = $secrets->secrets['db']['user'];
        $pass = $secrets->secrets['db']['password'];
        $dbname = $secrets->secrets['db']['database'];

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ];

        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}