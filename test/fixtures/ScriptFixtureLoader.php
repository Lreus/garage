<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Tests\fixtures\FixtureLoader;
use Garage\Sqlite\DatabaseManager;

$testDatabase = DatabaseManager::getTestDatabase();
if (file_exists($testDatabase)) {
    unlink($testDatabase);
}
$loader = new FixtureLoader();
$loader->loadFixture();
echo 'Fixtures loaded'.PHP_EOL;