<?php

namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Room extends Entity
{
    protected int $type_id;
    public function getType_id(): int { return $this->type_id; }
    public function setType_id(int $type_id): self
    {
        $this->type_id = $type_id;
        return $this;
    }

    protected int $user_id;
    public function getUser_id(): int { return $this->user_id; }
    public function setUser_id(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }

    protected int $address_id;
    public function getAddress_id(): int { return $this->address_id; }
    public function setAddress_id(int $address_id): self
    {
        $this->address_id = $address_id;
        return $this;
    }

    protected int $capacity;
    public function getCapacity(): int { return $this->capacity; }
    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;
        return $this;
    }

    protected float $surface;
    public function getSurface(): float { return $this->surface; }
    public function setSurface(float $surface): self
    {
        $this->surface = $surface;
        return $this;
    }

    protected float $price_day;
    public function getPrice_day(): float { return $this->price_day; }
    public function setPrice_day(float $price_day): self
    {
        $this->price_day = $price_day;
        return $this;
    }

    protected string $description;
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    // Optional image property
    protected ?string $image = null;
    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    // Optional relationship with Address (if you need to access related Address)
    protected ?Address $address = null;
    public function getAddress(): ?Address { return $this->address; }
    public function setAddress(?Address $address): self
    {
        $this->address = $address;
        return $this;
    }

    // Optional relationship with User (if you need to access related User)
    protected ?Users $user = null;
    public function getUser(): ?Users { return $this->user; }
    public function setUser(?Users $user): self
    {
        $this->user = $user;
        return $this;
    }
}