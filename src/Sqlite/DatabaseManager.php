<?php

namespace Garage\Sqlite;

use PDO;

class DatabaseManager
{
    /** @var Array<string, PDO> */
    private static array $connections = [];

    public static function connect(?string $absolutePath = null): PDO
    {
        if ($absolutePath === null) {
            $absolutePath = self::getTestDatabase();
        }

        self::initializeDatabaseConnection($absolutePath);

        return self::$connections[$absolutePath];
    }

    private static function initializeDatabaseConnection(string $absolutePath): void
    {
        if (!array_key_exists($absolutePath, self::$connections)) {
            self::$connections[$absolutePath] = new PDO('sqlite:' . $absolutePath);
        }
    }

    private static function getTestDatabase(): string
    {
        $databaseName = 'garage_db_test.sqlite';

        $path = __DIR__ . '/../../var';
        return realpath($path) . DIRECTORY_SEPARATOR . $databaseName;
    }
}