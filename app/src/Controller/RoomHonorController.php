<?php

namespace App\Controller;

use App\Model\Entity\Room;
use App\Model\Repository\RepoManager;
use Laminas\Diactoros\ServerRequest;
use Symplefony\View;


use Symplefony\Controller;


class RoomHonorController extends Controller
{

    // Affichage du formulaire de création d'un utilisateur
    public function add(): void
    {
        $view = new View( 'room:honor:create' );

        $data = [
            'title' => 'Ajouter un bien'
        ];

        $view->render( $data );
    }

    // Page d'accueil 
    public function index(): void
    {
        $view = new View( 'room:honor:rooms' );
        $rooms = RepoManager::getRM()->getRoomRepo()->getAll();
        $data = [
            'title' => 'Liste des biens',
            'rooms' => $rooms
        ];


        $view->render($data);

        }

    public function create( ServerRequest $request ): void
    {
        $room_data = $request->getParsedBody();

        $room = new Room( $room_data );

        $room_created = RepoManager::getRM()->getRoomRepo()->create( $room );

        if( is_null( $room_created ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/rooms-honor/add' );
        }

        $this->redirect( '/rooms' );
    }

    public function show( int $id ): void
    {
        $view = new View( 'room:honor:details' );
    
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

