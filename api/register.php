<?php

include_once 'DBApi.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(empty($_POST['username'])) {
        echo 'Please enter the username';
        exit;
    } else if(!preg_match('/^\w{3,}$/', $_POST['username'])) { // \w equals "[0-9A-Za-z_]"
        echo 'username must be longer and only contains  alphabets and numbers.';
        exit;
    }
    if(empty($_POST['email'])) {
        echo 'Please enter the email';
        exit;
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email format';
        exit;
    }
    if(empty($_POST['password'])) {
        echo 'Please enter the password';
        exit;
    } else if(strlen($_POST['password']) < 5) {
        echo 'Password should be 5 or more characters';
        exit;
    }
    if($_POST['password'] !== $_POST['confirm-password']) {
        echo "Password confirm doesn't match..";
        exit;
    }

    $username = htmlspecialchars(strtolower(trim($_POST['username'])));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    $response = DBApi::registerUser($username,$email,$password);
    if($response == APIResponse::USER_EXIST) {
        echo 'This username already exists..';
    } else if($response == APIResponse::SUCCESSFUL) {
        echo 'success';
    } else {
        echo 'Something goes wrong..';
    }

}

?>