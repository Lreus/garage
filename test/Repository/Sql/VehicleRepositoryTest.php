<?php

namespace Tests\Repository\Sql;

use Garage\Model\Vehicle;
use Garage\Repository\Sql\VehicleRepository;
use Garage\Sqlite\DatabaseManager;
use PHPUnit\Framework\TestCase;
use Tests\fixtures\FixtureLoader;

class VehicleRepositoryTest extends TestCase
{
    private VehicleRepository $repository;

    protected function setUp(): void
    {
        $fixtureLoader = new FixtureLoader();
        $fixtureLoader->loadFixture();
        $manager = DatabaseManager::connect();
        $this->repository = new VehicleRepository($manager);
    }

    public function testFindByRegistrationPlate(): void
    {
        $expectedPlate = '100-AAA-38';
        $vehicle = $this->repository->find($expectedPlate);

        self::assertInstanceOf(Vehicle::class, $vehicle);
        self::assertEquals($expectedPlate, $vehicle->getPlate());
    }

    public function testReturnNullOnNoMatch(): void
    {
        self::assertNull($this->repository->find('000-NOP-00'));
    }

    public function testAddingVehicle(): void
    {
        $newVehicle = new Vehicle('123-ABC-69', 'hiunday', 'ioniq');
        $this->repository->save($newVehicle);

        $databaseVehicle = $this->repository->find($newVehicle->getPlate());
        self::assertTrue($newVehicle->equals($databaseVehicle));
    }
}