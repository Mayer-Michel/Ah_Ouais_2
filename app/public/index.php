<?php

// Chargement du système d'autoload
require_once '../vendor/autoload.php';

use App\Controller\PageController;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Router;

$router = Router::create();

$router->get( '/', [ PageController::class, 'index' ] );
$router->get( '/mentions-legales', [ PageController::class, 'legalNotice' ]);

try{
    $router->dispatch();
}
// Page 404 avec status HTTP adequat pour les pages non listée dans le routeur
catch( RouteNotFoundException $e ) {
    http_response_code( 404 );
    echo 'Oups... La page n\'existe pas';
}
// Erreur 500 avec status HTTP adequat pour tout autre problème temporaire ou non
catch( Throwable $e ) {
    http_response_code( 500 );
    echo 'Erreur interne du serveur';
}