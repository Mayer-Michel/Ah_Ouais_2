<?php

namespace App\Model\Repository;

use App\Model\Entity\Types;
use Symplefony\Model\Repository;

class TypeRepository extends Repository
{
    protected function getTableName(): string { return 'types'; }

    /* Crud: Create */
    public function create( Types $type ): ?Types
    {
        $query = sprintf(
            'INSERT INTO `%s` 
                (`type`) 
                VALUES (:type)',
            $this->getTableName()
        );

        $sth = $this->pdo->prepare( $query );

        // Si la préparation échoue
        if( ! $sth ) {
            return null;
        }

        $success = $sth->execute([
            'type' => $type->getType(),
        ]);

        // Si echec de l'insertion
        if( ! $success ) {
            return null;
        }

        // Ajout de l'id de l'item créé en base de données
        $type->setId( $this->pdo->lastInsertId() );

        return $type;
    }

    /* cRud: Read tous les items */
    public function getAll(): array
    {
        return $this->readAll( Types::class );
    }

    /* cRud: Read un item par son id */
    public function getById( int $id ): ?Types
    {
        return $this->readById( Types::class, $id );
    }


}