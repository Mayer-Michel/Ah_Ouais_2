<?php

namespace App\Controller;

use Symplefony\View;
class PageController
{
    // Page d'accueil
    public function index(): void
    {
        $view = new View();
        $view->render();
    }

    // Page mentions légales
    public function legalNotice(): void
    {
        echo 'Les mentions légales !';
    }
}