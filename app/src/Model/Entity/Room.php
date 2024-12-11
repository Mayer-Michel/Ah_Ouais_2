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
    public function setSurface( float $surface ): self
    {
        $this->surface = $surface;
        return $this;
    }

    protected float $price_day;
    public function getPrice_day(): float { return $this->price_day; }
    public function setPrice_day( float $price_day ): self
    {
        $this->price_day = $price_day;
        return $this;
    }

    protected string $description;
    public function getDescription(): string { return $this->description; }
    public function setDescription( string $description ): self
    {
        $this->description = $description;
        return $this;
    }

    // TODO:
    // protected string $image;
    // public function getImage(): string { return $this->image; }
    // public function setImage( string $image ): self
    // {
    //     $this->image = $image;
    //     return $this;
    // }
    
}