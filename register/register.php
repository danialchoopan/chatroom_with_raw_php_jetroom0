<?php
require_once "../assets/php/config.php";
if (is_user_login()) {
    header("location: ../index.php");
}
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>نام نویسی</title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>
<div class="form-box">
    <form action="../assets/php/auth.php" method="post">
        <h1>نام نویسی در جتروم</h1>
        <p>نام نویسی در جتروم رایگان است و برای همیشه رایگان خواهد ماند</p>
        <input type="text" name="frm_register[nickname]" placeholder="نام مستعار">
        <input type="text" name="frm_register[username]" placeholder="نام کاربری">
        <input type="password" name="frm_register[password]" placeholder="رمز عبور">
        <input type="submit" name="submit_btn" value="نام نویسی">
    </form>
</div>
</body>
</html>
