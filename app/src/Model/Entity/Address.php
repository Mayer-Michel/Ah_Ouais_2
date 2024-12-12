<?php

namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Address extends Entity
{
    protected string $address;
    protected string $city;
    protected string $country;
    protected int $postal_code;

    // Change rooms to an array
    protected array $rooms = [];

    // Getter and Setter for Address
    public function getAddress(): string { return $this->address; }
    public function setAddress( string $address): self
    {
        $this->address = $address;
        return $this;
    }

    // Getter and Setter for City
    public function getCity(): string { return $this->city; }
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    // Getter and Setter for Country
    public function getCountry(): string { return $this->country; }
    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    // Getter and Setter for Postal Code
    public function getPostalCode(): int { return $this->postal_code; }
    public function setPostalCode(int $postal_code): self
    {
        $this->postal_code = $postal_code;
        return $this;
    }

    // Getter for Rooms (as an array)
    public function getRooms(): array { return $this->rooms; }

    // Method to add a room to the array
    public function addRoom($room): self
    {
        $this->rooms[] = $room;
        return $this;
    }
}