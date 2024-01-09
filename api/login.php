<?php
include_once 'DBApi.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['username'])) {
        echo 'Please enter the username';
        exit;
    }
    if(!isset($_POST['password'])) {
        echo 'Please enter the password';
        exit;
    }
    $username = htmlspecialchars(strtolower(trim($_POST['username'])));
    $password = htmlspecialchars(trim($_POST['password']));

    $response = DBApi::userLogin($username,$password);

    if($response->username !== null) {
        echo 'success';
        setcookie("userId", $response->id, time() + 86400, "/"); // 86400 seconds = 1 day
    } else {
        echo "User not found or password incorrect";
    }
}

?>