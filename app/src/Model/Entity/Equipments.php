<?php

namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Equipments extends Entity
{
    protected string $type_equipment;
    public function getType_equipments(): string { return $this->type_equipment; }
    public function setType_equipments( string $type_equipment ): self
    {
        $this->type_equipment = $type_equipment;
        return $this;
    }    
}