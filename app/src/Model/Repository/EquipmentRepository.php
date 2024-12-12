<?php

namespace App\Model\Repository;

use App\Model\Entity\Equipments;
use Symplefony\Model\Repository;

class EquipmentRepository extends Repository
{
    protected function getTableName(): string { return 'equipments'; }

    /* Crud: Create */
    public function create( Equipments $equipment ): ?Equipments
    {
        $query = sprintf(
            'INSERT INTO `%s` 
                (`type_equipment`) 
                VALUES (:type_equipment)',
            $this->getTableName()
        );

        $sth = $this->pdo->prepare( $query );

        // Si la préparation échoue
        if( ! $sth ) {
            return null;
        }

        $success = $sth->execute([
            'type_equipment' => $equipment->getType_equipments(),
        ]);

        // Si echec de l'insertion
        if( ! $success ) {
            return null;
        }

        // Ajout de l'id de l'item créé en base de données
        $equipment->setId( $this->pdo->lastInsertId() );

        return $equipment;
    }

    /* cRud: Read tous les items */
    public function getAll(): array
    {
        return $this->readAll( Equipments::class );
    }

    /* cRud: Read un item par son id */
    public function getById( int $id ): ?Equipments
    {
        return $this->readById( Equipments::class, $id );
    }


}