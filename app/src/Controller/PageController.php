<?php
namespace App\Controller;
class PageController
{
    // Page d'accueil
    public function index(): void
    {
        echo 'Bonjour depuis le Controller';
    }
    // Page mentions légales
    public function legalNotice(): void
    {
        echo 'Les mentions légales depuis le controller !';
    }
}