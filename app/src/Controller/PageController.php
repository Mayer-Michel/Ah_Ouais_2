<?php

namespace App\Controller;

use Symplefony\View;

use App\Model\UserModel;
class PageController
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
    }
}