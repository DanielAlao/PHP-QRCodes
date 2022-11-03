<?php

session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';

// Dynamic qrcode class
require_once BASE_PATH . '/lib/Static_Qrcode/Static_Qrcode.php';
$static_qrcode = new Static_Qrcode();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
    $static_qrcode->cancel($_POST['del_id'], $_POST['filename']);
