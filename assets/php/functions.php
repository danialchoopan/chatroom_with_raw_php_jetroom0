<?php

//massage
function send_message($text)
{
    global $database_connection;
    $username_id = $_SESSION['user_id'];
    $result = $database_connection->prepare("INSERT INTO `messages`(username_id,message) VALUES (?,?)");
    if ($result->execute([$username_id, $text]))
        return true;
    else
        return false;
}

function get_messages()
{
    global $database_connection;
    $result = $database_connection->prepare("SELECT * FROM `messages` ORDER BY `created_at` DESC LIMIT 7");
    if ($result->execute()) {
        return json_encode(array_reverse($result->fetchAll(2)));
    } else
        return false;
}

//users functions
function register_new_user($nick_name, $username, $password)
{
    global $database_connection;
    $result = $database_connection->prepare("INSERT INTO `users`(nick_name,username,password) VALUES (?,?,?)");
    if ($result->execute([$nick_name, $username, hash_password($password)]))
        return true;
    else
        return false;
}

function user_login($username, $password)
{
    global $database_connection;
    $result = $database_connection->prepare("SELECT * FROM `users` WHERE `username`=? AND `password`=?");
    if ($result->execute([$username, hash_password($password)]))
        if ($result->rowCount() > 0) {
            $user = $result->fetch(2);
            $_SESSION['user_id'] = $user['id'];
            return true;
        } else
            return false;
}

function is_user_login()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

function logout()
{
    if (isset($_SESSION['user_id'])) {
        unset($_SESSION['user_id']);
        session_destroy();
        return true;
    } else {
        return false;
    }
}

//end users functions


function hash_password($password)
{
    $salt = 'AASDG%^#^UVM$(%MQV($*(!)M:';
    return sha1($salt . $password);
}