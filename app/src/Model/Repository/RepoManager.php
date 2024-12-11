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


    private function __construct()
    {
        $pdo = Database::getPDO();

        $this->room_repository = new RoomRepository( $pdo );
        $this->user_repository = new UserRepository( $pdo );

    }
}