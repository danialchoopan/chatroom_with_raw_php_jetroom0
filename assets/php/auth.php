<?php
require_once 'config.php';
$refer = explode('/', $_SERVER['HTTP_REFERER']);
$refer = end($refer);
switch ($refer) {
    case "register.php":
        if (isset($_POST['frm_register'])) {
            $result_data = $_POST['frm_register'];
            var_dump($_POST['frm_register']);
            if (register_new_user($result_data['nickname'], $result_data['username'], $result_data['password'])) {
                header("location: ../../login/login.php");
            } else {
                header("location: ../register/register.php");
            }
        } else {
            exit("500");
        }
        break;

}

