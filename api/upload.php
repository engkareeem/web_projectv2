<?php

include_once 'DBApi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadedFile = $_FILES['file'];
    $response = DBApi::uploadImage($uploadedFile);
    if($response instanceof APIResponse) {
        echo $response->name;
    } else {
        echo $response;
    }
} else {
    echo APIResponse::ERROR->name;
}
?>