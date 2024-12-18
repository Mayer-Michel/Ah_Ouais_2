<?php

namespace App\Model\Repository;

use App\Model\Entity\Rentals;
use App\Model\Entity\Room;
use Symplefony\Model\Repository;

class RentalRepository extends Repository
{
    protected function getTableName(): string { return 'rentals'; }

    /* Crud: Create */
    public function create( Rentals $rental ): ?Rentals
    {
        $query = sprintf(
            'INSERT INTO `%s` 
                (`user_id`,`room_id`,`date_start`,`date_end`) 
                VALUES (:user_id,:room_id,:date_start,:date_end)',
            $this->getTableName()
        );

        $sth = $this->pdo->prepare( $query );

        // Si la préparation échoue
        if( ! $sth ) {
            return null;
        }

        $success = $sth->execute([
            'user_id' => $rental->getUser_id(),
            'room_id' => $rental->getRoom_id(),
            'date_start' => $rental->getDate_startStr(),
            'date_end' => $rental->getDate_endStr()
        ]);

        // Si echec de l'insertion
        if( ! $success ) {
            return null;
        }

        // Ajout de l'id de l'item créé en base de données
        $rental->setId( $this->pdo->lastInsertId() );

        return $rental;
    }

    /* cRud: Read tous les items */
    public function getAll(): array
    {
        return $this->readAll( Rentals::class );
    }

    public function getAllForReservation( int $id ): array
    {
        $query = sprintf(
            'SELECT * FROM `%s` Where user_id = :id' ,
            $this->getTableName()
        );

        $sth = $this->pdo->prepare( $query );
        // Si la préparation échoue
        if( ! $sth ) {
            return [];
        }
        $success = $sth->execute([ 'id' => $id] );
        // Si echec
        if( ! $success ) {
            return [];
        }
        // Récupération des résultats
        $rentals = [];
        while( $rental_data = $sth->fetch() ) {
            $rental = new Room( $rental_data );
            $rentals[] = $rental;
        }
        return $rentals;
    }

    /* cRud: Read un item par son id */
    public function getById( int $id ): ?Rentals
    {
        return $this->readById( Rentals::class, $id );
    }


}