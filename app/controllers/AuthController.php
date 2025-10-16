<?php
session_start();

require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct()
    {
        // On instancie le modèle une fois pour tout le contrôleur
        $this->userModel = new User();
    }

    // Affiche le formulaire d'inscription
    public function showRegister()
    {
        require_once __DIR__ . '/../views/register.php';
    }

    // Gère l'inscription
    public function register()
    {
        // On ne traite que si la requête vient d'un POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupère les champs du formulaire
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Vérifie si l'email existe déjà en base
            $existingUser = $this->userModel->findByEmail($email);

            if ($existingUser) {
                header('Location: index.php?route=register&error=1');
                exit;
            } else {

                // On crée le compte (le modèle hash le mot de passe)
                $this->userModel->create($username, $email, $password);
                header('Location: index.php?route=login');
                exit;
            }
        } else {
            require_once __DIR__ . '/../views/register.php';
        }
    }

    // Affiche le formulaire de connexion
    public function showLogin()
    {
        require_once __DIR__ . '/../views/login.php';
    }

    // Gère la connexion
    public function login()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupère email et mot de passe saisis
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Cherche l'utilisateur par email
            $user = $this->userModel->findByEmail($email);

            // Vérifier que l'utilisateur existe et que le mot de passe correspond au hash
            if ($user && password_verify($password, $user['password'])) {

                //  Si connexion OK, on remplit la session avec les infos de l'utilisateur
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['avatar'] = $user['avatar'];
                header('Location: index.php');
                exit;
            } else {
                header('Location: index.php?route=login&error=1');
                exit;
            }
        } else {
            // Affiche le formulaire si GET
            $this->showLogin();
        }
    }

    // Gère la déconnexion
    public function logout()
    {
        // Redémarre la session pour pouvoir la vider proprement
        session_start();

        // Vide les variables de session
        session_unset();

        // Détruit la session côté serveur
        session_destroy();
        header('Location: index.php');
        exit;
    }

}