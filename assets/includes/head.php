<?php
require_once 'pdo.php';
require_once 'pdo2.php';
date_default_timezone_set('Asia/Karachi');

session_start();
$script_name = $_SERVER['SCRIPT_NAME'];
$pattern = "~(/[\w-]+\.php|/)$~";
$name = '';
if (preg_match($pattern, $script_name, $matches)) {
    $name = trim($matches[1], '/');
}



if ($name != "login.php") {
    if (!isset($_SESSION["ovalfox_pos_username"])) {
        header("location:login.php");
    }
}

if (isset($_SESSION["ovalfox_pos_role_id"]) && $_SESSION['ovalfox_pos_role_id'] == "2") {
    if ($name != "sales.php") {

        header("location:sales.php");
    }
}
if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("location:login.php");
}



?>


<head>
    <title>Ovalfox - POS</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="MobileOptimized" content="320">
    <link rel="stylesheet" type="text/css" href="assets/css/datatables.css">

    <link rel="stylesheet" href="assets/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/nice-select.css">

    <link rel="stylesheet" type="text/css" href="assets/css/themes/full_white/fw_fnts.css">
    <link rel="stylesheet" type="text/css" href="assets/css/themes/full_white/fw_bs.css">
    <link rel="stylesheet" type="text/css" href="assets/css/themes/full_white/fw_fa_w.css">
    <link rel="stylesheet" type="text/css" href="assets/css/themes/full_white/fw_ifa.css">
    <link rel="stylesheet" type="text/css" href="assets/css/themes/full_white/fw_style.css">
    <style>
    .select2-dropdown {
        background-color: white !important;
    }

    .active-cell {
        background-color: grey !important;
        color: white !important;
    }
    </style>
    <link rel="shortcut icon" type="image/png" href="assets/images/ovalfox/icon.png">
    <link rel="stylesheet" id="theme-change" type="text/css" href="#">
    <link rel="stylesheet" href="assets/css/selectorCustom.css" />

    <?php if ($name == "login.php") {
    ?>
    <link rel="stylesheet" type="text/css" href="assets/css/auth.css">

    <?php } ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.49.2/apexcharts.min.css"
        integrity="sha512-YEwcgX5JXVXKtpXI4oXqJ7GN9BMIWq1rFa+VWra73CVrKds7s+KcOfHz5mKzddIOLKWtuDr0FzlTe7LWZ3MTXw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>