<?php

namespace App\Model\Repository;

use Symplefony\Database;
use Symplefony\Model\RepositoryManagerTrait;

class RepoManager
{
    use RepositoryManagerTrait;

    private RoomRepository $room_repository;
    public function getRoomRepo(): RoomRepository { return $this->room_repository; }

    private UserRepository $user_repository;
    public function getUserRepo(): UserRepository { return $this->user_repository; }

    private AddressRepository $address_repository;
    public function getAddressRepo(): AddressRepository { return $this->address_repository; }

    private RentalRepository $rental_repository;
    public function getRentalRepo(): RentalRepository { return $this->rental_repository; }

    private EquipmentRepository $equipment_repository;
    public function getEquipmentRepo(): EquipmentRepository { return $this->equipment_repository; }
    

    private function __construct()
    {
        $pdo = Database::getPDO();

        $this->room_repository = new RoomRepository( $pdo );
        $this->user_repository = new UserRepository( $pdo );
        $this->address_repository = new AddressRepository( $pdo );
        $this->rental_repository = new RentalRepository( $pdo );
        $this->equipment_repository = new EquipmentRepository( $pdo );
    }
}