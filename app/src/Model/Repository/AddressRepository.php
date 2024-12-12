<?php

namespace App\Model\Repository;

use App\Model\Entity\Address;
use Symplefony\Model\Repository;

class AddressRepository extends Repository
{
    protected function getTableName(): string { return 'address'; }

    /* Crud: Create */
    public function create( Address $address ): ?Address
    {
        $query = sprintf(
            'INSERT INTO `%s` 
                (`city`,`country`,`address`,`postal_code`) 
                VALUES (:city,:country,:address,:postal_code)',
            $this->getTableName()
        );

        $sth = $this->pdo->prepare( $query );

        // Si la préparation échoue
        if( ! $sth ) {
            return null;
        }

        $success = $sth->execute([
            'city' => $address->getCity(),
            'country' => $address->getCountry(),
            'address' => $address->getAddress(),
            'postal_code' => $address->getPostalCode()
        ]);

        // Si echec de l'insertion
        if( ! $success ) {
            return null;
        }

        // Ajout de l'id de l'item créé en base de données
        $address->setId( $this->pdo->lastInsertId() );

        return $address;
    }

    /* cRud: Read tous les items */
    public function getAll(): array
    {
        return $this->readAll( Address::class );
    }

    /* cRud: Read un item par son id */
    public function getById( int $id ): ?Address
    {
        return $this->readById( Address::class, $id );
    }


}