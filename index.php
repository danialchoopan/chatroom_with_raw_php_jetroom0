<?php
require_once "assets/php/config.php";
if (!is_user_login()) {
    header("location: login/login.php");
}
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>جتروم</title>
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
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
</body>
</html>
