<?php

session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';

// Users class
require_once BASE_PATH . '/lib/Users/Users.php';
$Users = new Users();

// Delete a user using user_id
if ($_SERVER['REQUEST_METHOD'] === 'POST')
    $Users->cancel($_POST['del_id']);
