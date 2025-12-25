<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Chargement des contrôleurs
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/BookController.php';
require_once __DIR__ . '/../app/controllers/MessageController.php';

$route = $_GET['route'] ?? '';

switch ($route) {

    case '':
        (new HomeController())->index();
        break;

    case 'register':
        (new AuthController())->showRegister();
        break;

    case 'login':
        (new AuthController())->showLogin();
        break;

    case 'doRegister':
        (new AuthController())->register();
        break;

    case 'doLogin':
        (new AuthController())->login();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'books':
        (new BookController())->showBooks();
        break;

    case 'book':
        (new BookController())->showBook();
        break;

    case 'account':
        (new HomeController())->showAccount();
        break;

    case 'uploadAvatar':
        (new HomeController())->uploadAvatar();
        break;

    case 'publicAccount':
        (new HomeController())->publicAccount($_GET['id'] ?? null);
        break;

    case 'editBook':
        require_once __DIR__ . '/../app/views/editBook.php';
        break;

    case 'updateBook':
        (new BookController())->updateBook();
        break;

    case 'deleteBook':
        (new BookController())->deleteBook();
        break;

    case 'messages':
        (new MessageController())->showMessages($_GET['id'] ?? null);
        break;

    case 'sendMessage':
        (new MessageController())->sendMessage();
        break;

    default:
        http_response_code(404);
        require_once __DIR__ . '/../app/views/404.php';
        break;
}
