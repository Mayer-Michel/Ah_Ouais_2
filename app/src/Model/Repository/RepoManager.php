<?php 

namespace App\Model\Repository;

use Symplefony\Database;

use Symplefony\Model\RepositoryManagerTrait;

class RepoManager
{
    use RepositoryManagerTrait;
    
    private UserRepository $user_repository;
    public function getUserRepo(): UserRepository { return $this->user_repository; }

    private AccueilRepository $room_repository;
    public function getRoomRepo(): AccueilRepository { return $this->room_repository; }


    private function __construct()
    {
        $pdo = Database::getPDO();

        $this->user_repository = new UserRepository( $pdo );
        $this->room_repository = new AccueilRepository( $pdo );
       
    }    
}