<?php

namespace App\Controller;


use App\Model\Entity\Users;
use App\Model\Repository\RepoManager;
use Laminas\Diactoros\ServerRequest;
use Symplefony\View;


use Symplefony\Controller;

class UserController extends Controller
{

    // Affichage du formulaire de création d'un utilisateur
    public function add(): void
    {
        $view = new View( 'user:create', auth_controller: AuthController::class );

        $data = [
            'title' => 'creation de compte'
        ];

        $view->render( $data );
    }


    public function create( ServerRequest $request ): void
    {
        $user_data = $request->getParsedBody();
        $user = new Users( $user_data );

        $user_created = RepoManager::getRM()->getUserRepo()->create( $user );

        if( is_null( $user_created ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/register' );
        }

        $this->redirect( '/rooms' );
    }

    // Page d'accueil 
    public function index(): void
    {
        $view = new View( 'room:rooms', auth_controller: AuthController::class );
        $rooms = RepoManager::getRM()->getRoomRepo()->getAll();
        $data = [
            'title' => 'Liste des biens',
            'rooms' => $rooms
        ];


        $view->render($data);

        }

    public function show( int $id ): void
    {
        $view = new View( 'user:details' );
    
        $user= RepoManager::getRM()->getUserRepo()->getById( $id );
    
        // Si l'utilisateur demandé n'existe pas
        if( is_null( $user ) ) {
            View::renderError( 404 );
            return;
        }
    
        $data = [
            'title' => 'User: '. $user->getLastname(),
            'user' => $user
        ];
    
        $view->render( $data );
    }
}

