<?php
session_start();
try {
    $database_connection = new PDO("mysql:host=localhost;dbname=chatroom0", "root", "");
} catch (Exception $exception) {
    echo "<p>" . "مشکلی در ارتباط با پایگاه داده رخ داده است" . "</p>";
    echo "<p>" . $exception->getMessage() . "</p>";
}
require_once 'functions.php';

//echo user_login("atom D","123456789");
//echo  register_new_user("12345678","atom D", "123456789");
//echo is_user_login();
//echo logout();
//for ($i = 0; $i < 100; $i++) {
//    sleep(1);
//    echo send_message($i."salam");
//}
//echo "done";
//echo get_messages();