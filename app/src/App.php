<?php
/**
 * Classe de démarrage de l'application
 */

// Déclaration du namespace de ce fichier
namespace App;


use Exception;
use Throwable;

use MiladRahimi\PhpRouter\Router;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Routing\Attributes;

use Symplefony\View;


use App\Controller\RoomController;
use App\Controller\RoomOwnerController;
use App\Controller\RoomUserController;
use App\Controller\AuthController;
use App\Controller\RentalController;
use App\Controller\UserController;
use App\Middleware\AuthMiddleware;
use App\Middleware\VisitorMiddleware;
use Symplefony\Security;

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
    
      /**
     * Hache une chaîne de caractères en servant du "sel" et du "poivre" définis dans .env
     *
     * @param  string $str Chaîne à hacher
     * 
     * @return string Résultat
     */
    public static function strHash( string $str ): string
    {
        return Security::strButcher( $str, $_ENV['security_salt'], $_ENV['security_pepper']);
    }

    // Démarrage de l'application
    public function start(): void
    {
        session_start();
        $this->registerRoutes();
        $this->startRouter();
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

        // -- Visiteurs (non-connectés) --
        $visitorAttributes = [
            Attributes::MIDDLEWARE => [ VisitorMiddleware::class ]
        ];
        $this->router->group( $visitorAttributes, function( Router $router ) {
            // Login
            $router->get( '/sign-in', [ AuthController::class, 'signIn' ] );
            $router->post( '/sign-in', [ AuthController::class, 'checkCredentials' ] );
        });
        // -- Utilisateurs connectés (tous rôles) --
        $visitorAttributes = [
            Attributes::MIDDLEWARE => [ AuthMiddleware::class ]
        ];

        $this->router->group( $visitorAttributes, function( Router $router ) {
            // Logout
            $router->get( '/sign-out', [ AuthController::class, 'signOut' ] );
        });

        

        // Page visiteur rooms

        $this->router->post('/', [ RoomController::class, 'create' ]);
        $this->router->get('/', [ RoomController::class, 'index' ]);

        // Page user rooms

        $this->router->get('/rooms-user', [ RoomUserController::class, 'index' ]);
        $this->router->get('/room-user/{id}', [ RoomUserController::class, 'show' ]);

        // Page owner rooms

        $this->router->get('/rooms-owner/add', [ RoomOwnerController::class, 'add' ]);
        $this->router->post('/rooms-owner', [ RoomOwnerController::class, 'create' ]);
        $this->router->get('/rooms-owner', [ RoomOwnerController::class, 'index' ]);
        $this->router->get('/room-owner/{id}', [ RoomOwnerController::class, 'show' ]);
        

        // Page profil

        $this->router->get('/register', [ UserController::class, 'add' ]);
        $this->router->post('/register', [ UserController::class, 'create' ]);
        $this->router->get('/profile/{id}', [ UserController::class, 'show' ]);

        // Resérvé
        $this->router->post('/rooms-res/add/{id}', [ RentalController::class, 'create' ]);
        $this->router->get('/rooms-res', [ RentalController::class, 'meslocation' ]);
        
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