<?php
session_start(); // Pour pouvoir utiliser les sessions

require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct()
    {
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $existingUser = $this->userModel->findByEmail($email);

            if ($existingUser) {
                echo "Email déjà utilisé.";
            } else {
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
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['avatar'] = $user['avatar'];
                header('Location: index.php');
                exit;
            } else {
                echo "Email ou mot de passe incorrect.";
            }
        } else {
            // Affiche le formulaire si GET
            $this->showLogin();
        }
    }

    // Gère la déconnexion
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }

}