<?php
header('Content-Type: application/json');
require_once 'config.php';
switch ($_GET["msg_do"]) {
    case "get_all":
        if (is_user_login()) {
            $messages = json_decode(get_messages());
//            var_dump($messages);
            $messages_return = [];
            foreach ($messages as $message) {
                global $database_connection;
                $message_return = [];
                $username_id = $message->username_id;
                $result_users = $database_connection->prepare("SELECT * FROM `users` WHERE `id`=?");
                $result_users->execute([$username_id]);
                $message_return["nickname"] = $result_users->fetch(2)["nick_name"];
                $message_return["message"] = $message->message;
                $messages_return[] = $message_return;
            }
            echo json_encode($messages_return);
        } else {
            exit("500");
        }
        break;
    case "send":
        if (is_user_login()) {
            if (isset($_POST['msg_text'])) {
                if ($_POST['msg_text'] != "") {
                    $msg_text = $_POST['msg_text'];
                    if (send_message($msg_text)) {
                        echo json_encode(['status' => "send"]);
                    } else {
                        echo json_encode(['status' => "error database"]);
                    }
                }
            }
        } else {
            exit("500");
        }
        break;
}