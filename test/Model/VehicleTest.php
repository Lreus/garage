<?php

namespace Tests\Model;

use Garage\Model\Vehicle;
use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    public function testCreateVehicle(): void
    {
        $plate = '111-AAA-38';
        $model = 'sandero';
        $brand = 'dacia';

        $vehicle = new Vehicle(
            $plate,
            $brand,
            $model
        );

        self::assertInstanceOf(Vehicle::class, $vehicle);
        self::assertEquals($plate, $vehicle->getPlate());
        self::assertEquals($model, $vehicle->getModel());
        self::assertEquals($brand, $vehicle->getBrand());
    }
}
