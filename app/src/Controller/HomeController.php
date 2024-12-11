<?php

namespace App\Controller;

use Symplefony\View;


use Symplefony\Controller;


class HomeController extends Controller
{
    // Page d'accueil 
    public function index(): void
    {
        $view = new View( 'page:home' );

        $data = [
            'title' => 'Accueil - AhOuais'
        ];

        $view->render($data);

        }
    }