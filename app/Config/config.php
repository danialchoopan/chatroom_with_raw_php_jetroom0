<?php

define('DB_TYPE', 'sqlite'); // 'mysql' or 'sqlite'

// MySQL Config
define('DB_HOST', 'localhost');
define('DB_NAME', 'jetroom_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// SQLite Config
define('SQLITE_PATH', __DIR__ . '/../../data/database.sqlite');

// App Config
define('BASE_URL', 'http://localhost:8000');
define('UPLOAD_DIR', __DIR__ . '/../../public/static/uploads/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png']);

// Session Config
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
