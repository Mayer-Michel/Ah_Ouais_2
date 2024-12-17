<?php

namespace App\Model\Repository;

use App\Model\Entity\Equipments;
use Symplefony\Model\Repository;

class EquipmentRepository extends Repository
{
    protected function getTableName(): string { return 'equipments'; }
    private function getMappingRoom(): string { return 'room_equipment'; }

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

    /* cRud: Read avec liaison de tous les items reliés à une voiture donnée */
    public function getAllForRoom( int $id ): array
    {
        $query = sprintf(
            'SELECT c.* FROM `%1$s` as c 
                JOIN `%2$s` as cc ON cc.equipment_id = c.id
                WHERE cc.room_id=:id',
            $this->getTableName(),
            $this->getMappingRoom()
        );
        $sth = $this->pdo->prepare( $query );
        // Si la préparation échoue
        if( ! $sth ) {
            return [];
        }
        $success = $sth->execute([
            'id' => $id
        ]);
        // Si echec de l'insertion
        if( ! $success ) {
            return [];
        }
        $equipments = [];
        while( $equipment_data = $sth->fetch() ) {
            $equipments[] = new Equipments( $equipment_data );
        }
        return $equipments;
    }

    /* Delete toutes les liaisons de catégories d'une voiture donnée */
    public function detachAllForRoom( int $id ): bool
    {
        $query = sprintf(
            'DELETE FROM `%s` WHERE room_id=:id',
            $this->getMappingRoom()
        );
        $sth = $this->pdo->prepare( $query );
        // Si la préparation échoue
        if( ! $sth ) {
            return false;
        }
        $success = $sth->execute([ 'id' => $id ]);
        return $success;
    }


    /* Insére les liaisons de catégories demandée pour d'une voiture donnée */
    public function attachForRoom( array $ids_equipments, int $room_id ): bool
    {
        $query_values = [];
        foreach( $ids_equipments as $equipment_id ) {
            $query_values[] = sprintf( '( %s,%s )', $room_id, $equipment_id );
        }
        $query = sprintf(
            'INSERT INTO `%s` 
                (`room_id`,`equipment_id`) 
                VALUES %s',
            $this->getMappingRoom(),
            implode( ',', $query_values )
        );
        $sth = $this->pdo->prepare( $query );
        // Si la préparation échoue
        if( ! $sth ) {
            return false;
        }
        return $sth->execute();
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