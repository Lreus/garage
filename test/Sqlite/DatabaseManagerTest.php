<?php

namespace Tests\Sqlite;

use Garage\Sqlite\DatabaseManager;
use PHPUnit\Framework\TestCase;

class DatabaseManagerTest extends TestCase
{
    /** @var string[] */
    private array $file_to_remove = [];

    public function testBuildingPath()
    {
        self::assertEquals("/home/lreus/Project/perso/php/garage/var", realpath($this->appendVarDirectory()));
    }

    private function appendVarDirectory(string $fileName = ''): string
    {

        $pathElements = [__DIR__, '..', '..', 'var'];
        if (!empty(trim($fileName))) {
            $pathElements[] = $fileName;
        }

        return implode(DIRECTORY_SEPARATOR, $pathElements);
    }

    public function testConnectionForDatabaseIsSingleton(): void
    {
        $database = $this->appendVarDirectory('garage_db_test.sqlite');

        $first = DatabaseManager::connect($database);
        $second = DatabaseManager::connect($database);

        self::assertSame($first, $second);

        $this->file_to_remove[] = $database;
    }

    protected function tearDown(): void
    {
        foreach ($this->file_to_remove as $fileName) {
            unlink(realpath($fileName));
        }
    }
}