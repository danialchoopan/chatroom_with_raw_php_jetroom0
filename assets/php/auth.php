<?php
require_once 'config.php';
$refer = explode('/', $_SERVER['HTTP_REFERER']);
$refer = end($refer);
switch ($refer) {
    case "register.php":
        if (isset($_POST['frm_register'])) {
            $result_data = $_POST['frm_register'];
            if ($result_data['nickname'] != "" && $result_data['username'] && $result_data['password']) {
                if (register_new_user($result_data['nickname'], $result_data['username'], $result_data['password'])) {
                    $_SESSION['msg'] = "شما با موفقیت نام نویسی شدید حالا میتواند وارد سایت شوید";
                    $_SESSION['msg_status'] = "success";
                    header("location: ../../login/login.php");
                } else {
                    header("location: ../../register/register.php");
                    $_SESSION['msg'] = "خطا هنگام نام نویس لطفا بعدا امتحان کنید";
                    $_SESSION['msg_status'] = "error";
                }
            } else {
                header("location: ../../register/register.php");
                $_SESSION['msg'] = "نام مستعار و نام کاربری و رمز عبور اجباری است";
                $_SESSION['msg_status'] = "error";
            }
        } else {
            exit("500");
        }
        break;
    case "login.php":
        if (isset($_POST['frm_login'])) {
            $result_data = $_POST['frm_login'];
            if ($result_data['username'] && $result_data['password']) {
                if (user_login($result_data['username'], $result_data['password'])) {
                    $_SESSION['msg'] = "خوش آمدید";
                    $_SESSION['msg_status'] = "success";
                    header("location: ../../index.php");
                } else {
                    header("location: ../../login/login.php");
                    $_SESSION['msg'] = "نام کاربری یا رمزعبور اشتباه است";
                    $_SESSION['msg_status'] = "error";
                }
            } else {
                header("location: ../../login/login.php");
                $_SESSION['msg'] = " نام کاربری و رمز عبور اجباری است";
                $_SESSION['msg_status'] = "error";
            }
        }else{
            exit("500");
        }
        break;
}

