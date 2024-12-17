<?php

namespace App\Model\Entity;

use DateTime;
use Symplefony\Model\Entity;

class Rentals extends Entity
{
    protected DateTime $date_start;
    public function getDate_start(): DateTime { return $this->date_start; }
    public function setDate_start( string|DateTime $date_start ): self
    {
        $this->date_start = $date_start;
        return $this;
    }

    protected DateTime $date_end;
    public function getDate_end(): DateTime { return $this->date_end; }
    public function setDate_end( DateTime $date_end ): self
    {
        $this->date_end = $date_end;
        return $this;
    } 

    protected int $user_id;
    public function getUser_id(): int { return $this->user_id; }
    public function setUser_id( int $user_id ): self
    {
        $this->user_id = $user_id;
        return $this;
    }  
    
    protected int $room_id;
    public function getRoom_id(): int { return $this->room_id; }
    public function setRoom_id( int $room_id ): self
    {
        $this->room_id = $room_id;
        return $this;
    }  

    public function getDate_startStr() : string
    {
        return self::dateToStr($this->date_start);
    }

    public function getDate_endStr() : string
    {
        return self::dateToStr($this->date_end);
    }

    private static function dateToStr(DateTime $date) : string
    {
        return $date->format('Y-m-d H:i:s');
    }
}