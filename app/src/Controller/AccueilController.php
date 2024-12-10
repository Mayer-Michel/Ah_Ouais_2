<?php

namespace App\Controller;

use App\Model\Entity\Room;
use App\Model\Repository\RepoManager;
use Laminas\Diactoros\ServerRequest;
use Symplefony\Controller;
use Symplefony\View;

class AccueilController extends Controller
{

     /**
     * Pages Administrateur
     */

    // Admin: Affichage du formulaire de création d'un utilisateur
    public function add(): void
    {
        $view = new View( 'accueil:create' );

        $data = [
            'title' => 'ajouter une chambre'
        ];

        $view->render( $data );
    }

    // Admin: Traitement du formulaire de création d'une catégorie
    public function create( ServerRequest $request ): void
    {
        $room_data = $request->getParsedBody();

        $room = new Room( $room_data );

        $room_created = RepoManager::getRM()->getRoomRepo()->create( $room );

        if( is_null( $room_created ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/accueil/room' );
        }

        $this->redirect( '/accueil' );
    }

    // Admin: Liste 
    public function index(): void
    {
        $view = new View( 'accueil:list' );

        $data = [
            'title' => 'Liste des chambres',
            'rooms' => RepoManager::getRM()->getRoomRepo()->getAll()
        ];

        $view->render ( $data );
    }

    // Admin: Affichage détail/modification
    public function show( int $id ): void
    {
        $view = new View( 'accueil:details' );

        $room = RepoManager::getRM()->getRoomRepo()->getById( $id );

        // Si l'utilisateur demandé n'existe pas
        if( is_null( $room ) ) {
            View::renderError( 404 );
            return;
        }

        $data = [
            'title' => 'Surface: '. $room->getSurface(),
            'room' => $room
        ];

        $view->render( $data );
    }

    // Admin: Traitement du formulaire de modification
    public function update( ServerRequest $request, int $id ): void
    {
        $room_data = $request->getParsedBody();

        $room = new Room( $room_data );
        $room->setId( $id );

        $room_updated = RepoManager::getRM()->getRoomRepo()->update( $room );

        if( is_null( $room_updated ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/'. $id );
        }

        $this->redirect( '/' );
    }

    // Admin: Suppression
    public function delete( int $id ): void
    {
        $delete_success = RepoManager::getRM()->getRoomRepo()->deleteOne( $id );

        if( ! $delete_success ) {
            // TODO: gérer une erreur
            $this->redirect( '/'. $id );
        }

        $this->redirect( '/' );
    }

}