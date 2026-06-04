<?php

require_once __DIR__ . '/../app/Config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance()->getConnection();
    echo "Connection successful!\n";

    $tables = ['users', 'rooms', 'messages', 'private_messages'];
    foreach ($tables as $table) {
        $stmt = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='$table'");
        $result = $stmt->fetch();
        if ($result) {
            echo "Table '$table' exists.\n";
        } else {
            echo "Table '$table' DOES NOT exist.\n";
        }
    }

    $roomCount = $db->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
    echo "Total rooms: $roomCount\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
