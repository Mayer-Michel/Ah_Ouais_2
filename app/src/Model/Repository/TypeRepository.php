<?php

namespace App\Model\Repository;

use App\Model\Entity\Type;

use Symplefony\Model\Repository;

class TypeRepository extends Repository
{
    protected function getTableName(): string { return 'types'; }
    
    /* Crud: Create */
    // TODO: la méthode
    /* cRud: Read tous les items */

    public function getAll(): array
    {
        return $this->readAll( Type::class );
    }

    /* cRud: Read un item par son id */
    public function getById( int $id ): ?Type
    {
        return $this->readById( Type::class, $id );
    }
}