<?php
include_once __DIR__ . '/../DBApi.php';
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    if($filter === 'all') generateProducts();
     else generateProducts(['category' => $_POST['filter']]);
}
function generateProducts($filter=[],$order=[]):void {
    $products = DBApi::getAllProducts($filter,$order);
    $user = DBApi::ensureLogin();
    $cart = DBApi::getCart();
    $content = '';
    foreach($products as $product) {
        $fav='fa-regular';
        $shCart = 'fa-regular';
        if($user->username !== null) {
            $fav = in_array($product->_id,iterator_to_array($user->favoritesList)) ? 'fa-solid':'fa-regular';
            $shCart = array_key_exists((string)$product->_id,$cart) ? 'fa-solid':'fa-regular';
        }
        global $price;

        if($product->discount > 0) {
            $discount = $product->price - $product->price*$product->discount/100;
            $price = "<s>$product->price$</s><br>
                        $discount$";
        } else {
            $price = $product->price.'$';
        }
        $content .= "<div class=\"card-item\" onclick=\"location.href = 'product_view.php?product_id=$product->_id'\">
                <img src=\"api/getImage.php?id={$product->imageID}\" alt=\"image\">
                <div class=\"actions\">
                    <div class=\"icon $fav fa-heart\" onclick='fav_product(this,\"{$product->_id}\")'></div>
                    <div class=\"add-to-cart-button icon $shCart fa-cart-shopping\" onclick='cart_product(this,\"$product->_id\")'></div>
                    
                </div>
                <div class=\"header\">
                    <div class=\"title\">
                        $product->title
     
                    </div>
                    <div class=\"price\">
                        $price
                    </div>
                </div>
            </div>";
    }
    $content .= "<script>
   
</script>";
    echo $content;

}

function generateCustomProducts($products):void {

    foreach($products as $productID) {
        $user = DBApi::ensureLogin();
        $product = DBApi::getProductByID($productID);
        $fav='fa-regular';
        $shCart = 'fa-regular';
        $cart = DBApi::getCart();
        if($user->username !== null) {
            $fav = in_array($product->_id,iterator_to_array($user->favoritesList)) ? 'fa-solid':'fa-regular';
            $shCart = array_key_exists((string)$product->_id,$cart) ? 'fa-solid':'fa-regular';
        }
        echo "<div class=\"card-item\" onclick=\"location.href = 'product_view.php?product_id=$productID'\">
                <img src=\"api/getImage.php?id={$product->imageID}\" alt=\"image\">
                <div class=\"actions\">
                    <div class=\"icon $fav fa-heart\" onclick='fav_product(this,\"{$product->_id}\")'></div>
                    <div class=\"add-to-cart-button icon $shCart fa-cart-shopping\" onclick='cart_product(this,\"$product->_id\")'></div>
                    
                </div>
                <div class=\"header\">
                    <div class=\"title\">
                        $product->title
                    </div>
                    <div class=\"price\">
                        $product->price
                    </div>
                </div>
            </div>";
    }
}

?>