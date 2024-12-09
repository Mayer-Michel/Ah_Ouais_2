<?php

namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Type extends Entity
{
    protected string $type;

    public function getType(): string { return $this->type; }

    public function setType( string $type ): self 
    {
        $this->type = $type;
        return $this;
    }
}