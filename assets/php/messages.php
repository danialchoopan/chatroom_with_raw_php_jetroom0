<?php
header('Content-Type: application/json');
require_once 'config.php';
switch ($_GET["msg_do"]) {
    case "get_all":
        if (is_user_login()) {
            echo get_messages();
        } else {
            exit("500");
        }
        break;
    case "send":
        if (is_user_login()) {
            if (isset($_POST['mgs_text'])) {
                if ($_POST['mgs_text'] != "") {
                    $msg_text = $_POST['mgs_text'];
                    if (send_message($msg_text)) {
                        echo json_encode(['status'=>"send"]);
                    } else {
                        echo json_encode(['status'=>"error database"]);
                    }
                }
            }
        } else {
            exit("500");
        }
        break;
}