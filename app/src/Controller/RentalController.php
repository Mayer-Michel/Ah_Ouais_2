<?php

namespace App\Controller;

use App\Model\Entity\Rentals;
use App\Model\Repository\RepoManager;
use App\Session;
use DateTime;
use Laminas\Diactoros\ServerRequest;



use Symplefony\Controller;
use Symplefony\View;

class RentalController extends Controller
{
    public function create(ServerRequest $request, int $id): void
    {
        // Get the rental data from the form
        $rental_data = $request->getParsedBody();

        // Ensure the user is logged in
        $user_id = Session::get(Session::USER)->getId();
        if (!$user_id) {
            // Handle error if the user is not logged in
            $this->redirect('/sign-in');
            return;
        }

        $rental_data['user_id'] = $user_id;
        $rental_data['room_id'] = $id;

        // Create the rental
        $rental = new Rentals($rental_data);

        // Use RepoManager to save the rental
        $rental_created = RepoManager::getRM()->getRentalRepo()->create($rental);

        // Handle failure
        if (is_null($rental_created)) {
            // Redirect to the room owner page with an error
            $this->redirect('/room-owner/{id}');
            return;
        }

        // Successful reservation, redirect to rooms list
        $this->redirect('/rooms-res');
    }   
    
    // Afficher toutes les locations 
    public function meslocation(): void
    {
        // Récupérer les locations depuis le repository
        $locations = RepoManager::getRM()->getRentalRepo()->getAll();

        // Passer les locations à la vue
        $view = new View('myRental:my_rental', auth_controller: AuthController::class);
        $data = [
            'title' => 'Liste des locations',
            'locations' => $locations
        ];

        // Rendre la vue avec les données
        $view->render($data);
    }
}