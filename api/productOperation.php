<?php
include_once 'DBApi.php';
//$title, $description, $price, $category, $imageID, $stock
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type'])) {
    if($_POST['type'] === 'delete' && isset($_POST['product_id'])) {
        $response = DBApi::removeProduct($_POST['product_id']);
        if($response == APIResponse::SUCCESSFUL) {
            echo 'success';
        } else {
            echo 'Something goes wrong..';
        }
        exit;
    }
    if(!isset($_POST['title'],$_POST['description'],$_POST['price'],$_POST['category'],$_POST['stock'],$_POST['discount'])) {
        echo 'Please fill all fields.';
        exit;
    }

    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    $category = htmlspecialchars($_POST['category']);
    $stock = htmlspecialchars($_POST['stock']);
    $discount = htmlspecialchars($_POST['discount']);

    $imageID = -1;

    if(strlen($title) < 3 || strlen($title) > 30) {
        echo 'Title must be shorter than 30 and longer than 3 characters';
        exit;
    }
    if(!is_numeric($price) || $price < 1) {
        echo 'Invalid price';
        exit;
    }
    if(!is_numeric($stock) || $stock < 1) {
        echo 'Invalid stock number';
        exit;
    }
    if(!is_numeric($discount) || $discount < 0 || $discount > 100) {
        echo 'Invalid discount ' .$discount;
        exit;
    }

    $price = (int)$price;
    $stock = (int)$stock;
    $category = strtolower($category);
    $imageID = null;

    if(!isset($_FILES['file']) && $_POST['type'] === 'add') {
        echo 'Please attach an image';
        exit;
    } else if(isset($_FILES['file'])) {
        $uploadedFile = $_FILES['file'];
        $response = DBApi::uploadImage($uploadedFile);
        if($response == APIResponse::INVALID_IMAGE) {
            echo 'Please attach an valid image..';
            exit;
        } else if($response == APIResponse::ERROR) {
            echo 'Error occurred while uploading the image';
            exit;
        } else {
            $imageID = $response;
        }
    }


    $response = 'Bad Request';
    if($_POST['type'] === 'add') {
        $response = DBApi::addProduct($title,$description,$price,$category,$imageID,$stock,$discount);
    } else if($_POST['type'] === 'edit' && isset($_POST['product_id'])) {
        $product = new Product($title,$description,$price,$category,$imageID,null,$discount,$stock,null);
        $product->id = $_POST['product_id'];
        $response = DBApi::updateProduct($product);
    }
    if($response == APIResponse::SUCCESSFUL) {
        echo 'success';
    } else {
        echo 'Something goes wrong..';
    }

} else {
    echo 'Bad Request';
}


?>