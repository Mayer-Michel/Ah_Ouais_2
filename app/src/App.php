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

use App\Controller\AdminController;
use App\Controller\AuthController;
use App\Controller\PageController;
use App\Middleware\AdminMiddleware;
use Symplefony\View;

final class App
{
    private static ?self $app_instance = null;

    // Le routeur de l'application
    private Router $router;

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
        // Pages communes
        $this->router->get( '/', [ PageController::class, 'index' ] );
        $this->router->get( '/mentions-legales', [ PageController::class, 'legalNotice' ]);
        
        // Pages d'admin
        $adminAttributes = [
            Attributes::PREFIX => '/admin',
            Attributes::MIDDLEWARE => [ AdminMiddleware::class ]
        ];
        $this->router->group( $adminAttributes, function( Router $router ) {
            $router->get( '', [ AdminController::class, 'dashboard' ]);
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
        }
    } 

    private function __clone() { }
    public function __wakeup()
    {
        throw new Exception( "Non c'est interdit !" );
    }
}