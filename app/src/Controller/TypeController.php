<?php

namespace App\Controller;

use App\Model\Repository\RepoManager;
use Symplefony\Controller;
use Symplefony\View;

class TypeController extends Controller
{
    // Admin: Liste
    public function index(): void
    {
        $view = new View( 'type:admin:list' );
        $data = [
            'title' => 'Liste des types',
            'types' => RepoManager::getRM()->getTypeRepo()->getAll()
        ];
        $view->render( $data );
    }
}