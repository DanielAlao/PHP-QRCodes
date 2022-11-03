<?php

require_once 'config/config.php';

$db = getDbInstance();

$user = $_POST['username'];
$user_p = $_POST['password'];
$select = array('id', 'user_name', 'password', 'series_id', 'remember_token', 'expires', 'user_type');
$format = $db->where('user_name', $user);
$count = $db->getValue ("user_accounts", "count(user_name)");


$uppercase = preg_match('@[A-Z]@', $user_p);
$lowercase = preg_match('@[a-z]@',  $user_p);
$number = preg_match('@[0-9]@',  $user_p);
$specialChars = preg_match('@[^\w]@',  $user_p);

if ($count > 0) {
    session_start();
    $_SESSION['register_fail'] = 'user name taken';
    header('Location: register.php');
} 
elseif (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($user_p) < 10){
    session_start();
    $_SESSION['register_fail_password'] = 'Password should be at least 10 characters in length and should include at least one upper case letter, one number, and one special character.';
    header('Location: register.php'); 
} 
else{
    if (isset($_POST)) {
        $data = array(
            'user_name' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'user_type' => 'user'
    
        );
            $id = $db->insert('user_accounts', $data);
            // Authentication successfull redirect user
            session_start();
            $_SESSION['success_msg'] = 'success!';
            header('Location: register.php');

        }
}