<?php

namespace App\Model\Repository;

use App\Model\Entity\Rentals;
use App\Model\Entity\Users;
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
            'date_start' => $rental->getDate_start(),
            'date_end' => $rental->getDate_end()
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

    /* cRud: Read un item par son id */
    public function getById( int $id ): ?Rentals
    {
        return $this->readById( Rentals::class, $id );
    }


}