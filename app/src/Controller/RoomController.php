<?php

namespace App\Controller;

use App\Model\Entity\Room;
use App\Model\Repository\RepoManager;
use Laminas\Diactoros\ServerRequest;
use Symplefony\View;


use Symplefony\Controller;


class RoomController extends Controller
{

    // Page d'accueil 
    public function index(): void
    {
        $view = new View( 'room:rooms' );
        $rooms = RepoManager::getRM()->getRoomRepo()->getAll();
        $data = [
            'title' => 'Liste des biens',
            'rooms' => $rooms
        ];


        $view->render($data);

        }


    public function show( int $id ): void
    {
        $view = new View( 'room:' );
    
        $room = RepoManager::getRM()->getRoomRepo()->getById( $id );
    
        // Si l'utilisateur demandé n'existe pas
        if( is_null( $room ) ) {
            View::renderError( 404 );
            return;
        }
    
        $data = [
            'title' => 'Room: '. $room->getDescription(),
            'room' => $room
        ];
    
        $view->render( $data );
    }
}

