<?php

require_once __DIR__ . '/../app/Config/config.php';

// Simple Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) === 0) {
        $relative_class = substr($class, $len);
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
});

use App\Models\User;
use App\Models\Message;
use App\Models\PrivateMessage;

try {
    $userModel = new User();
    $msgModel = new Message();
    $pmModel = new PrivateMessage();

    // Create some users
    $users = [
        ['username' => 'ali', 'password' => 'password'],
        ['username' => 'reza', 'password' => 'password'],
        ['username' => 'sara', 'password' => 'password'],
        ['username' => 'mahdi', 'password' => 'password']
    ];

    foreach ($users as $u) {
        if (!$userModel->findByUsername($u['username'])) {
            $userModel->create($u['username'], $u['password']);
        }
    }

    $u_ali = $userModel->findByUsername('ali')['id'];
    $u_reza = $userModel->findByUsername('reza')['id'];
    $u_sara = $userModel->findByUsername('sara')['id'];
    $u_mahdi = $userModel->findByUsername('mahdi')['id'];

    // Public Messages
    $msgModel->create($u_ali, 1, "سلام به همگی! به اتاق عمومی خوش آمدید.");
    $msgModel->create($u_reza, 1, "سلام علی جان، ممنون.");
    $msgModel->create($u_sara, 2, "کسی اینجا با PHP کار کرده؟");
    $msgModel->create($u_ali, 2, "بله، من در حال یادگیری MVC هستم.");

    // Private Messages
    $pmModel->create($u_ali, $u_reza, "سلام رضا، چطوری؟");
    $pmModel->create($u_reza, $u_ali, "خوبم علی، تو چطوری؟");
    $pmModel->create($u_ali, $u_reza, "میای بریم بیرون؟");

    echo "Database seeded successfully!\n";

} catch (Exception $e) {
    echo "Seeding failed: " . $e->getMessage() . "\n";
}
