<?php

namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Room extends Entity
{
    protected int $capacity;
    public function getCapacity(): int { return $this->capacity; }
    public function setCapacity( int $capacity ): self
    {
        $this->capacity = $capacity;
        return $this;
    }
   
    protected float $surface;
    public function getSurface(): float { return $this->surface; }
    public function setSurface( int $surface ): self
    {
        $this-> surface= $surface;
        return $this;
    }

    protected string $price_day;
    public function getPrice_day(): string { return $this->price_day; }
    public function setPrice_day( int $price_day ): self
    {
        $this->price_day = $price_day;
        return $this;
    }

    protected string $description;
    public function getDescription(): string { return $this->description; }
    public function setDesctiption( int $description ): self
    {
        $this->description = $description;
        return $this;
    }

}