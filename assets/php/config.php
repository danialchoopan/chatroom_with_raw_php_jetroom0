<?php
session_start();
try {
    $database_connection = new PDO("mysql:host=127.0.0.1;dbname=chatroom0", "root", "");
} catch (Exception $exception) {
    echo "<p class='form-box-p error-box' style='margin: 10px'>" . "مشکلی در ارتباط با پایگاه داده رخ داده است" . "</p>";
    echo "<p class='form-box-p error-box' style='margin: 10px'>" . $exception->getMessage() . "</p>";
}
require_once 'functions.php';
