<?php
require_once 'DBApi.php';
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type'], $_POST['product_id']) && !empty($_COOKIE['userId'])) {
    $response = "Bad Request";
    if($_POST['type'] === 'add-fav') {
        $response = DBApi::addProductToFav($_POST['product_id'],$_COOKIE['userId'])->name;
    } else if($_POST['type']==='remove-fav') {
        $response = DBApi::addProductToFav($_POST['product_id'],$_COOKIE['userId'],'$pull')->name;
    } else if($_POST['type']==='add-cart') {
        $response = DBApi::addProductToCart($_POST['product_id'],$_POST['count'])->name;
    } else if($_POST['type']==='remove-cart') {
        $response = DBApi::addProductToCart($_POST['product_id'], 1, 'remove')->name;
    }else if($_POST['type'] === 'purchase' && isset($_POST['count'])) {
        $response = DBApi::purchaseProduct($_POST['product_id'],$_COOKIE['userId'],$_POST['count'])->name;
    } else if($_POST['type'] === 'purchase-cart' && isset($_POST['count'])) {
        $cart = DBApi::getCart();
        foreach ($cart as $id=>$count) {
            $product = DBApi::getProductByID($id);
            if($product->title === null) continue;
            $response = DBApi::purchaseProduct($id,$_COOKIE['userId'],$count);
            if($response == APIResponse::ERROR) {
                $response = 'ERROR';
                break;
            }
        }
        if($response !== 'ERROR') {
            $response = 'success';
            DBApi::clearCart();

        }

    }else if($_POST['type'] === 'price-query') {
        $cart = DBApi::getCart();
        $totalItemsPrice = 0;
        $totalPrice = 0.5;
        foreach ($cart as $id => $count) {
            $product = DBApi::getProductByID($id);
            if($product->title == null) continue;
            $price = $product->price * $count;
            $totalItemsPrice += $price;
            $totalPrice += $price - $price * ($product->discount/100);
        }
        $response = $totalItemsPrice . ';' . $totalPrice;
    }
    echo $response;
} else {
    echo 'Bad Request';
}

?>