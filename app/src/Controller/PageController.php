<?php

namespace App\Controller;

use Symplefony\Controller;
use Symplefony\View;

use App\Model\UserModel;
class PageController extends Controller
{
    // Page d'accueil
    public function index(): void
    {
        $view = new View( 'page:home' );

        $data = [
            'title' => 'Accueil - AhOuais.com'
        ];

        $view->render( $data );
    }

    // Page mentions légales
    public function legalNotice(): void
    {
        echo 'Les mentions légales !';

        var_dump( UserModel::getById(4) );
    }
}