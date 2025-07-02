<?php
$route = $_GET['route'] ?? '';

switch ($route) {
    case 'register':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->showRegister();
        break;

    case 'login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->showLogin();
        break;

    case 'doRegister':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;

    case 'doLogin':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'books':
         require_once __DIR__ . '/../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->showBooks();
        break;

    case 'book':
        require_once __DIR__ . '/../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->showBook();
        break;
        
    case 'account':
        require_once __DIR__ . '/../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->showAccount();
        break;
    
    case 'uploadAvatar':
        require_once __DIR__ . '/../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->uploadAvatar();
        break;
        
    case 'publicAccount':
        require_once __DIR__ . '/../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->publicAccount($_GET['id']);
        break;    

    case 'editBook':
        require_once __DIR__ . '/../app/views/editBook.php';
        break;
        
    case 'updateBook':
        require_once __DIR__ . '/../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->updateBook();
        break;

    case 'deleteBook':
        require_once __DIR__ . '/../app/controllers/BookController.php';
        $controller = new BookController();
        $controller->deleteBook();
        break;
    
    case 'messages':
        require_once __DIR__ . '/../app/controllers/MessageController.php';
        $controller = new MessageController();
        $receiverId = isset($_GET['id']) ? $_GET['id'] : null;
        $controller->showMessages($receiverId);
        break;

    case 'sendMessage':
        require_once __DIR__ . '/../app/controllers/MessageController.php';
        $controller = new MessageController();
        $controller->sendMessage();
        break;

        
    default:
        require_once __DIR__ . '/../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
}
