<?php
/**
 * Classe de démarrage de l'application
 */

// Déclaration du namespace de ce fichier
namespace App;

use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\RoomController;
use App\Controller\RoomOwnerController;
use App\Controller\RoomUserController;

use Exception;
use Throwable;

use MiladRahimi\PhpRouter\Router;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;

use App\Controller\UserController;
use Symplefony\View;

final class App
{
    private static ?self $app_instance = null;

    // Le routeur de l'application
    private Router $router;

    public function getRouter(): Router { return $this->router; }

    public static function getApp(): self
    {
        // Si l'instance n'existe pas encore on la crée
        if( is_null( self::$app_instance ) ) {
            self::$app_instance = new self();
        }

        return self::$app_instance;
    }

    // Démarrage de l'application
    public function start(): void
    {
        session_start();
        $this->registerRoutes();
        $this->startRouter();
        var_dump(Session::get(Session::USER));
    }

    private function __construct()
    {
        // Création du routeur
        $this->router = Router::create();
    }

    // Enregistrement des routes de l'application
    private function registerRoutes(): void
    {
        // -- Formats des paramètres --
        // {id} doit être un nombre
        $this->router->pattern( 'id', '\d+' );

        
        // Page Home 

        $this->router->get( '/', [ HomeController::class, 'index' ] );

        // Page visiteur rooms

        $this->router->post('/rooms', [ RoomController::class, 'create' ]);
        $this->router->get('/rooms', [ RoomController::class, 'index' ]);

        // Page user rooms

        $this->router->get('/rooms-user', [ RoomUserController::class, 'index' ]);

        // Page owner rooms

        $this->router->get('/rooms-owner/add', [ RoomOwnerController::class, 'add' ]);
        $this->router->post('/rooms-owner', [ RoomOwnerController::class, 'create' ]);
        $this->router->get('/rooms-owner', [ RoomOwnerController::class, 'index' ]);


        // Page profil

        $this->router->get('/register', [ UserController::class, 'add' ]);
        $this->router->post('/register', [ UserController::class, 'create' ]);
        $this->router->post('/rooms', [ UserController::class, 'index' ]);
        $this->router->get('/profile/{id}', [ UserController::class, 'show' ]);
        
        // page login
        $this->router->get('/login', [LoginController::class, 'show']);
        $this->router->post('/login', [LoginController::class, 'login']);

        
    }

    // Démarrage du routeur
    private function startRouter(): void
    {
        try{
            $this->router->dispatch();
        }
        // Page 404 avec status HTTP adequat pour les pages non listée dans le routeur
        catch( RouteNotFoundException $e ) {
            View::renderError( 404 );

        }
        // Erreur 500 avec status HTTP adequat pour tout autre problème temporaire ou non
        catch( Throwable $e ) {
            View::renderError( 500 );
            var_dump($e);
        }
    } 

    private function __clone() { }
    public function __wakeup()
    {
        throw new Exception( "Non c'est interdit !" );
    }
}