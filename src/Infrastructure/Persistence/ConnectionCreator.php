<?php

namespace App\Pdo\Infrastructure\Persistence;

class ConnectionCreator
{
  public static function createConnection()
  {
    $databasePath = __DIR__ . "/../../../banco.sqlite";
    return new \PDO("sqlite:" . $databasePath);
  }
}
