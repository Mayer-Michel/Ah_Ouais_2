<?php

namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Room_equipments extends Entity
{
    protected int $room_id;
    public function getRoom_id(): int { return $this->room_id; }
    public function setRoom_id( int $room_id ): self
    {
        $this->room_id = $room_id;
        return $this;
    }  

    protected int $equipment_id;
    public function getEquipment_id(): int { return $this->equipment_id; }
    public function setEquipment_id( int $equipment_id ): self
    {
        $this->equipment_id = $equipment_id;
        return $this;
    }    
}