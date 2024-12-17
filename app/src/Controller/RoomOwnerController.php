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
        $view = new View( 'room:owner:create', auth_controller: AuthController::class );

        $data = [
            'title' => 'Ajouter un bien',
            'equipments' => RepoManager::getRM()->getEquipmentRepo()->getAll()
        ];

        $view->render( $data );
    }

    // Page d'accueil 
    public function index(): void
    {
        $view = new View( 'room:owner:rooms', auth_controller: AuthController::class );
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
        $file = $_FILES['image'] ?? null;

        // Handle image upload if provided
        $imagePath = null;
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $uploadDirectory = '/image/';
    
            // // Ensure the directory exists
            // if (!is_dir($uploadDirectory)) {
            //     mkdir($uploadDirectory, 777, true);  // Create directory with permissions
            // }

            $fileName = uniqid() . '_' . basename($file['name']);
            $imagePath =  $fileName;

            if (!move_uploaded_file($file['tmp_name'], $imagePath)) {
                echo "Failed to upload image.";
                $this->redirect('/rooms-owner/add');
                return;
            }   
        }
        $image_data['image'] = $imagePath ?? null;
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
            'description' => $room_data['description'],
            'image' => $image_data['image']
        ];

        $room = new Room( $data_room );
        $room->setUser_id(Session::get(Session::USER) -> getId());

        $room_created = RepoManager::getRM()->getRoomRepo()->create( $room );

        if( is_null( $room_created ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/rooms-owner/add' );
        }

            // Si pas de données post car aucun coché, on crée un tableau vide
            $equipments =  $room_data[ 'equipments' ] ?? [];
            $room_created->addEquipments( $equipments );

        $this->redirect( '/rooms-owner' );
    }

    public function show( int $id ): void
    {
        $view = new View( 'room:owner:details', auth_controller: AuthController::class );
    
        $room = RepoManager::getRM()->getRoomRepo()->getById( $id );
    
        // Si l'utilisateur demandé n'existe pas
        if( is_null( $room ) ) {
            View::renderError( 404 );
            return;
        }

        $room_equipments_ids = array_map( function( $equipment ){ return $equipment->getId(); }, $room->getEquipments() );
    
        $data = [
            'title' => 'Room: '. $room->getDescription(),
            'room' => $room,
            'equipments' => RepoManager::getRM()->getEquipmentRepo()->getAll(),
            'room_equipments_ids' => $room_equipments_ids
        ];
    
        $view->render( $data );
    }
}