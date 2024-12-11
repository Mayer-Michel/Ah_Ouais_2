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
                (`capacity`,`surface`,`price_day`,`description`) 
                VALUES (:capacity,:surface,:price_day,:description)',
            $this->getTableName()
        );

        $sth = $this->pdo->prepare( $query );

        // Si la préparation échoue
        if( ! $sth ) {
            return null;
        }

        $success = $sth->execute([
            'capacity' => $room->getCapacity(),
            'surface' => $room->getSurface(),
            'price_day' => $room->getPrice_day(),
            'description' => $room->getDescription()
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