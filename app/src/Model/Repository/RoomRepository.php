<?php

namespace App\Model\Repository;

use App\Model\Entity\Room;
use Symplefony\Model\Repository;

class RoomRepository extends Repository
{
    protected function getTableName(): string { return 'rooms'; }

    /* Crud: Create */
    public function create( Room $room ): ?Room
    {
        
        $query = sprintf(
            'INSERT INTO `%s` 
                (`type_id`,`user_id`,`address_id`,`capacity`,`surface`,`price_day`,`description`,`image`) 
                VALUES (:type_id, :user_id, :address_id, :capacity, :surface, :price_day, :description, :image)',
            $this->getTableName()
        );

        $sth = $this->pdo->prepare( $query );

        // Si la préparation échoue
        if( ! $sth ) {
            return null;
        }

        $success = $sth->execute([
            'type_id' => $room->getType_id(),
            'user_id' => $room->getUser_id(),
            'address_id' => $room->getAddress_id(),
            'capacity' => $room->getCapacity(),
            'surface' => $room->getSurface(),
            'price_day' => $room->getPrice_day(),
            'description' => $room->getDescription(),
            'image' => $room->getImage()
        ]);

        // Si echec de l'insertion
        if( ! $success ) {
            return null;
        }

        // Ajout de l'id de l'item créé en base de données
        $room->setId( $this->pdo->lastInsertId() );

        return $room;
    }

    /* cRud: Read tous les items */
    public function getAll(): array
    {
        return $this->readAll( Room::class );
    }

    /* cRud: Read un item par son id */
    public function getById( int $id ): ?Room
    {
        return $this->readById( Room::class, $id );
    }


}