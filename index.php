<?php
require_once "assets/php/config.php";
if(!is_user_login()){
    header("location: login/login.php");
}