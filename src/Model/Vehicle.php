<?php

namespace Garage\Model;

class Vehicle
{
    public function __construct(
        private string $plate,
        private string $brand,
        private string $model,
    ){}

    public function getPlate(): string
    {
        return $this->plate;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function equals(Vehicle $vehicle): bool
    {
        return $this->plate === $vehicle->getPlate() &&
            $this->getBrand() === $vehicle->getBrand() &&
            $this->getModel() === $vehicle->getModel();
    }
}
