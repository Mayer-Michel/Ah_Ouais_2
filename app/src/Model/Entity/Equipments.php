<?php

namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Equipments extends Entity
{
    protected string $type_equipments;
    public function getType_equipments(): string { return $this->type_equipments; }
    public function setType_equipments( string $type_equipments ): self
    {
        $this->type_equipments = $type_equipments;
        return $this;
    }    
}