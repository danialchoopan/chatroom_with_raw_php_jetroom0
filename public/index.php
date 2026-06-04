<?php

require_once __DIR__ . '/../app/Config/config.php';

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;

$router = new Router();

// Auth Routes
$router->add('/login', 'AuthController', 'showLogin', 'GET');
$router->add('/login', 'AuthController', 'login', 'POST');
$router->add('/register', 'AuthController', 'showRegister', 'GET');
$router->add('/register', 'AuthController', 'register', 'POST');
$router->add('/logout', 'AuthController', 'logout', 'GET');

// Chat Routes
$router->add('/chat', 'ChatController', 'index', 'GET');
$router->add('/api/chat/messages', 'ChatController', 'getMessages', 'GET');
$router->add('/api/chat/send', 'ChatController', 'sendMessage', 'POST');

// Private Routes
$router->add('/private', 'PrivateController', 'chat', 'GET');
$router->add('/api/private/messages', 'PrivateController', 'getMessages', 'GET');
$router->add('/api/private/send', 'PrivateController', 'sendMessage', 'POST');

// Upload Routes
$router->add('/api/upload', 'UploadController', 'upload', 'POST');

// Default Route
if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '') {
    header('Location: /chat');
    exit;
}

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
