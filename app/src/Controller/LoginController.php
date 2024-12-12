<?php

namespace App\Controller;

use App\Model\Entity\Users;
use App\Session;
use Symplefony\View;
use Symplefony\Database;
use Exception;
use Laminas\Diactoros\ServerRequest;
use Symplefony\Controller;

class LoginController extends Controller
{
    /**
     * Display the login page
     */
    public function show(): void
    {
        $view = new View('page:login');
        $data = ['title' => 'Connexion'];
        $view->render($data);
    }

    /**
     * Handle login form submission
     */
    public function login(ServerRequest $request): void
    {
        $data = $request->getParsedBody();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            View::renderError(405); // Method Not Allowed
            return;
        }

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // Validate inputs
        if (empty($email) || empty($password)) {
            $this->redirectWithError("Email ou mot de passe incorrect.");
            return;
        }

        try {
            $pdo = Database::getPDO();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            if (!$user || !password_verify($password, $user['password'])) {
                $this->redirectWithError("Email ou mot de passe incorrect.");
                return;
            }

            $user_obj = new Users( $user );

            // Start session and set user info
            Session::set(Session::USER, $user_obj);

            // Redirect to the home page
            $this->redirect("/");

        } catch (Exception $e) {
            View::renderError(500);
            var_dump($e); // For debugging purposes only
        }
    }

    /**
     * Redirect with error message
     */
    private function redirectWithError(string $message): void
    {
        header("Location: /login?error=" . urlencode($message));
        exit();
    }
}