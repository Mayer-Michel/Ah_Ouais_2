<?php
namespace App\Middleware;
use Closure;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use Symplefony\IMiddleware;
use App\Controller\AuthController;
class SalesmanMiddleware implements IMiddleware
{
    public function handle( ServerRequestInterface $request, Closure $next ): mixed
    {
        if( AuthController::isSalesman() ) {
            return $next( $request );
        }
        return new RedirectResponse( '/' );
    }
}