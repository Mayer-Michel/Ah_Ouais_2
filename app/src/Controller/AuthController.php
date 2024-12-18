<?php

namespace App\Controller;

use App\App;
use Laminas\Diactoros\ServerRequest;
use Symplefony\Controller;
use Symplefony\View;
use App\Session;
use App\Model\Entity\Users;
use App\Model\Repository\RepoManager;

/**
 * Gestion des fonctionnalités d'authentification
 */
class AuthController extends Controller
{
    /**
     * L'utilisateur est connecté
     *
     * @return bool
     */
    public static function isAuth(): bool
    {
        return !is_null( Session::get( Session::USER ) );
    }
    
    /**
     * L'utilisateur connecté est un commercial
     *
     * @return bool
     */
    public static function isSalesman(): bool
    {
        if( !self::isAuth() ) {
            return false;
        }
        $user = Session::get( Session::USER );
        
        return $user->getRole() === Users::ROLE_OWNER;
    }


    public static function getUser(): ?Users
    {
        if( !self::isAuth() ) {
            return null;
        }
        return Session::get( Session::USER );
    }

    // --- Actions de routes ---
    // - Visiteurs seulement -
    /**
     * Page du formulaire d'authentification
     *
     * @return void
     */
    public function signIn(): void
    {
        $view = new View( 'auth:sign-in', auth_controller: self::class );
        $data = [
            'title' => 'Connexion - AhOuais.com'
        ];
        $view->render( $data );
    }
    
    /**
     * Traitement du formulaire d'authentification
     *
     * @param  mixed $request
     * @return void
     */
    public function checkCredentials( ServerRequest $request ): void
    {
        $form_data = $request->getParsedBody();
        // Si les données du formulaire sont vides ou inexistantes
        if( empty( $form_data['email'] ) || empty( $form_data['password'] ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/sign-in' );
        }
        // On nettoie les espaces en trop
        $email = trim( $form_data['email'] );
        $password = trim( $form_data[ 'password' ] );
        // Si les données sont vides après nettoyage
        if( empty( $email ) || empty( $password ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/sign-in' );
        }
         // Chiffrement du mot de passe
         $password = App::strHash( $password );

        // On vérifie les identifiants de connexion
        $user = RepoManager::getRM()->getUserRepo()->checkAuth( $email, $password );
        // Si échec
        if( is_null( $user ) ) {
            // TODO: gérer une erreur
            $this->redirect( '/sign-in' );
        }
        // On enregistre l'utilisateur correspondant dans la session
        Session::set( Session::USER, $user );
        // On redirige vers une page en fonction du rôle de l'utilisateur
        $redirect_url = match( $user->getRole() ) {
            Users::ROLE_CUSTOMER => '/rooms-user',
            Users::ROLE_OWNER => '/rooms-owner'
        };
        $this->redirect( $redirect_url );
    }

    // -- Utilisateurs connectés (tous rôles) --    
    /**
     * Déconnexion de la session
     *
     * @return void
     */
    public function signOut(): void
    {
        Session::remove( Session::USER );
        $this->redirect( '/' );
    }
    
}