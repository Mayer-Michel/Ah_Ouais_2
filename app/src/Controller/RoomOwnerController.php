<?php

namespace App\Controller;

use App\Model\Entity\Address;
use App\Model\Entity\Room;
use App\Model\Repository\RepoManager;
use App\Session;
use Laminas\Diactoros\ServerRequest;
use Symplefony\View;


use Symplefony\Controller;


class RoomOwnerController extends Controller
{

    // Affichage du formulaire de création d'un utilisateur
    public function add(): void
    {
        $view = new View( 'room:owner:create' );

        $data = [
            'title' => 'Ajouter un bien'
        ];

        $view->render( $data );
    }

    // Page d'accueil 
    public function index(): void
    {
        $view = new View( 'room:owner:rooms' );
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
        
        $address = new Address( $room_data );
        $address_created = RepoManager::getRM()->getAddressRepo()->create( $address );
        if( is_null( $address_created ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/rooms-owner/add' );
        }

        $data_room = [
            'type_id' => $room_data['type_id'],
            'user_id' => Session::get(Session::USER)->getId(),
            'address_id' => $address_created->getId(),
            'capacity' => $room_data['capacity'],
            'surface' => $room_data['surface'],
            'price_day' => $room_data['price_day'],
            'description' => $room_data['description']
        ];

        $room = new Room( $data_room );
        $room->setUser_id(Session::get(Session::USER) -> getId());

        $room_created = RepoManager::getRM()->getRoomRepo()->create( $room );

        if( is_null( $room_created ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/rooms-owner/add' );
        }

        $this->redirect( '/rooms-owner' );
    }

    public function show( int $id ): void
    {
        $view = new View( 'room:owner:details' );
    
        $room = RepoManager::getRM()->getRoomRepo()->getById( $id );
        var_dump($room);die;
    
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