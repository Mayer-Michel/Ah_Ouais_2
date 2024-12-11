<?php

namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Address extends Entity
{
    protected string $address;
    public function getAddress(): string { return $this->address; }
    public function setAddressget( string $address ): self
    {
        $this->address = $address;
        return $this;
    }   

    protected string $city;
    public function getCity(): string { return $this->city; }
    public function setCity( string $city ): self
    {
        $this->city = $city;
        return $this;
    }    

    protected string $country;
    public function getCountry(): string { return $this->country; }
    public function setCountry( string $country ): self
    {
        $this->country = $country;
        return $this;
    }   

    protected string $postal_code;
    public function getPostal_code(): int { return $this->postal_code; }
    public function setPostal_code( int $postal_code ): self
    {
        $this->postal_code = $postal_code;
        return $this;
    }    
}