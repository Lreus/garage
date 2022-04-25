<?php

namespace Tests\fixtures;

use Garage\Sqlite\DatabaseManager;

class FixtureLoader
{

    private const CREATE_TABLE_VEHICLE = <<<SQL
CREATE TABLE Vehicle (
    plate varchar(10),
    model varchar(30),
    brand varchar(30),
    PRIMARY KEY (plate)
);
SQL;
    private const INSERT_VEHICLE = 'INSERT INTO Vehicle values(:plate, :model, :brand)';

    public function loadFixture(): void
    {
        $manager = DatabaseManager::connect();
        $manager->query('DROP TABLE IF EXISTS Vehicle;');
        $manager->query(self::CREATE_TABLE_VEHICLE);
        for($i = 100; $i < 500; $i++) {
            $parameters = [
                'plate' => sprintf('%d-AAA-38', $i),
                'model' => 'a car',
                'brand' => 'a brand',
            ];
            $manager
                ->prepare(self::INSERT_VEHICLE)
                ->execute($parameters);
        }
    }
}
