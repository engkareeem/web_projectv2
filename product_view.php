<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!--   <script src="https://unpkg.com/@rive-app/canvas@2.7.0"></script>-->
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/product_view.js"></script>
    <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome" href="/css/app-wa-9846671ed7c9dd69b10c93f6b04b31fe.css?vsn=d">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-light.css">
</head>
<body>

<?php
include_once 'api/DBApi.php';
include './components/navbar.php';
if($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['product_id'])) {
    echo "
        <script>
            $(() => {
                location.href = \"index.php\";
            });
        </script>
    ";
}
$product = DBApi::getProductByID($_GET['product_id']);
$user = DBApi::ensureLogin();
if($user->username === null) {
    echo "
        <script>
            $(() => {
                $('#add-to-cart-button, #buy-now-button').prop('disabled','true');
            });
        </script>
    ";
}
?>

<div class="product-view-container">
    <div class="image-container">
        <img src="api/getImage.php?id=<?php echo $product->imageID?>" alt="image">
    </div>
    <div class="information-container">

        <div class="header">
            <h1><?php echo $product->title ?></h1>
            <div class="header-actions" >
                <div class="icon fa-regular fa-heart" onclick="fav_product(this,'<?php echo $product->id?>')" ></div>
            </div>
        </div>
        <div class="rating-container">
            <div class="icon fa-solid fa-star"></div>
            <div class="icon fa-solid fa-star"></div>
            <div class="icon fa-solid fa-star"></div>
            <div class="icon fa-solid fa-star"></div>
            <div class="icon fa-solid fa-star-sharp-half-stroke"></div>
            <div class="reviews">(69 Reviews)</div>
        </div>
        <div class="description">
            <?php echo $product->description ?>
        </div>
        <div class="buying-container">
            <div class="price-container">
                <div class="price-label">
                    Price: <?php echo $product->price ?>$
                </div>
            </div>
            <div class="actions-container">
                <button id="add-to-cart-button" class="btn btn-outline-primary" onclick="shop_operation('add-cart','<?php echo $product->id?>')">Add to Cart</button>
                <button id="buy-now-button" class="btn btn-primary" onclick="location.href = 'shopping_cart.php?product_id=' + '<?php echo $product->id?>';">Buy Now</button>
            </div>
        </div>

    </div>
</div>
<script src="js/product.js"></script>

<?php include './components/footer.php' ?>
<style>
    #footer {
        width: 100%;
    }
</style>

</body>
</html>