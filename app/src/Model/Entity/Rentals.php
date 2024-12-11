<?php

namespace App\Model\Entity;

use DateTime;
use Symplefony\Model\Entity;

class Rentals extends Entity
{
    protected DateTime $date_start;
    public function getDate_start(): DateTime { return $this->date_start; }
    public function setDate_start( DateTime $date_start ): self
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
}