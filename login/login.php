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
    <title>ورود</title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>
<div class="form-box">
    <form action="../assets/php/auth.php" method="post">
        <h1 class="form-box-h1">ورود به جتروم</h1>
        <?php
        if (isset($_SESSION['msg']) || isset($_SESSION['msg_status'])):
            ?>
            <p class="form-box-p <?php echo $_SESSION['msg_status']; ?>-box">
                <?php echo $_SESSION['msg']; ?>
            </p>
            <?php
            unset($_SESSION['msg']);
            unset($_SESSION['msg_status']);
        endif;
        ?>

        <input type="text" name="frm_login[username]" placeholder="نام کاربری">
        <input type="password" name="frm_login[password]" placeholder="رمز عبور">
        <input type="submit" name="submit_btn" value="ورود">
        <a class="a-link-auth" href="../register/register.php">هنوز در جتروم نام نویسی نکرده اید همین حالا نام نویسی کنید !</a>
    </form>
</div>
</body>
</html>
