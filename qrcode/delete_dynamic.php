<?php

session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';

// Dynamic qrcode class
require_once BASE_PATH . '/lib/Dynamic_Qrcode/Dynamic_Qrcode.php';
$dynamic_qrcode = new Dynamic_Qrcode();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
    $dynamic_qrcode->cancel($_POST['del_id'], $_POST['filename']);
