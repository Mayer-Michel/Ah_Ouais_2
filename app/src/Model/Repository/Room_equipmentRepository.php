<?php

namespace App\Model\Repository;

use App\Model\Entity\Room_equipments;
use App\Model\Entity\Types;
use Symplefony\Model\Repository;

class Room_equipmentRepository extends Repository
{
    protected function getTableName(): string { return 'room_equipment'; }

    /* Crud: Create */
    public function create( Room_equipments $room_equipment ): ?Room_equipmentRepository
    {
        $query = sprintf(
            'INSERT INTO `%s` 
                (`room_id`,`equipment_id`) 
                VALUES (:room_id,:equipment_id)',
            $this->getTableName()
        );

        $sth = $this->pdo->prepare( $query );

        // Si la préparation échoue
        if( ! $sth ) {
            return null;
        }

        $success = $sth->execute([
            'room_id' => $room_equipment->getRoom_id(),
            'equipment_id' => $room_equipment->getEquipment_id()
        ]);

        // Si echec de l'insertion
        if( ! $success ) {
            return null;
        }

        // Ajout de l'id de l'item créé en base de données
        $room_equipment->setId( $this->pdo->lastInsertId() );

        return $room_equipment;
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