<?php
/**
 * Classe de démarrage de l'application
 */

// Déclaration du namespace de ce fichier
namespace App;

use App\Controller\AccueilController;
use Exception;
use Throwable;

use MiladRahimi\PhpRouter\Router;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;

use App\Controller\UserController;
use MiladRahimi\PhpRouter\Routing\Attributes;
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

        
        // Pages accueil
        $AccueilAttributes = [
        Attributes::PREFIX => '/accueil'];

        $this->router->group( $AccueilAttributes, function( Router $router ) {
            $router->get( '', [ AccueilController::class, 'index' ] );
            $router->get( '/room/add', [ AccueilController::class, 'add' ] );
            $router->post( '/room', [ AccueilController::class, 'create' ]);
            $router->get( '/mentions-legales', [ AccueilController::class, 'legalNotice' ]);

            $router->get( '/users/subscribe', [ UserController::class, 'displaySubscribe' ] );
            $router->post( '/users', [ UserController::class, 'create' ] );

        });

        
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