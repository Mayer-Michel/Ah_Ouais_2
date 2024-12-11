<?php

namespace App\Model\Repository;

use App\Model\Entity\Users;
use Symplefony\Model\Repository;

class UserRepository extends Repository
{
    protected function getTableName(): string { return 'users'; }

    /* Crud: Create */
    public function create( Users $user ): ?Users
    {
        $query = sprintf(
            'INSERT INTO `%s` 
                (`email`,`password`,`firstname`,`lastname`,`phone_number`) 
                VALUES (:email,:password,:firstname,:lastname,:phone_number)',
            $this->getTableName()
        );

        $sth = $this->pdo->prepare( $query );

        // Si la préparation échoue
        if( ! $sth ) {
            return null;
        }

        $success = $sth->execute([
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'phone_number' => $user->getPhone_number()
        ]);

        // Si echec de l'insertion
        if( ! $success ) {
            return null;
        }

        // Ajout de l'id de l'item créé en base de données
        $user->setId( $this->pdo->lastInsertId() );

        return $user;
    }

    /* cRud: Read tous les items */
    public function getAll(): array
    {
        return $this->readAll( Users::class );
    }

    /* cRud: Read un item par son id */
    public function getById( int $id ): ?Users
    {
        return $this->readById( Users::class, $id );
    }


}