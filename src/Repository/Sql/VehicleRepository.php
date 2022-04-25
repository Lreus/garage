<?php

namespace Garage\Repository\Sql;

use Garage\Model\Vehicle;
use JetBrains\PhpStorm\ArrayShape;

class VehicleRepository
{
    private const VEHICLE_BY_PLATE_REQUEST = 'SELECT * FROM Vehicle where plate = :plate';
    private const SAVE_VEHICLE_REQUEST = 'INSERT INTO Vehicle values(:plate, :model, :brand)';
    private const DELETE_VEHICLE_REQUEST = 'DELETE FROM Vehicle WHERE plate = :plate';

    public function __construct(
        private \PDO $connection
    ) {}

    public function find(string $plate): ?Vehicle
    {
        $vehicleData = $this->getVehicleByPlate($plate);

        if (is_array($vehicleData)) {
            return $this->denormalizeVehicle($vehicleData);
        }

        return null;
    }

    /**
     * @return array<string, mixed>|null
     */
    #[ArrayShape([
        'plate' => 'string',
        'model' => 'string',
        'brand' => 'string',
    ])]
    public function getVehicleByPlate(string $plate): ?array
    {
        $statement = $this->connection->prepare(self::VEHICLE_BY_PLATE_REQUEST);
        $statement->bindParam('plate', $plate);
        $statement->execute();
        $vehicleData = $statement->fetch();
        $statement->closeCursor();

        return is_array($vehicleData) ? $vehicleData : null;
    }

    /**
     * @param array $vehicleData array<string, string>
     */
    private function denormalizeVehicle(array $vehicleData): Vehicle
    {
        return new Vehicle(
            $vehicleData['plate'],
            $vehicleData['brand'],
            $vehicleData['model']
        );
    }

    public function save(Vehicle $vehicle): void
    {
        $this->connection
            ->prepare(self::SAVE_VEHICLE_REQUEST)
            ->execute($this->normalizeVehicle($vehicle));
    }

    #[ArrayShape(['plate' => "string", 'brand' => "string", 'model' => "string"])]
    public function normalizeVehicle(Vehicle $vehicle): array
    {
        return [
            'plate' => $vehicle->getPlate(),
            'brand' => $vehicle->getBrand(),
            'model' => $vehicle->getModel(),
        ];
    }

    public function remove(string $plate): void
    {
        $this->connection->prepare(self::DELETE_VEHICLE_REQUEST)
            ->execute(['plate' => $plate]);
    }
}
