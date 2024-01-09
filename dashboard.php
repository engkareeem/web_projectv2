<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-light.css">
</head>
<body>
<?php
include_once 'api/DBApi.php';
include './components/admin-navbar.php';
$products = DBApi::getAllProducts();
$totalProfit = 0;
$productsNumber = count($products);
$totalProductsStock = 0;
$totalSoldProducts = 0;
$usersCount = DBApi::getUsersCount();
$adminsCount = DBApi::getUsersCount(true);
if($usersCount instanceof APIResponse) $usersCount = 0;
if($adminsCount instanceof APIResponse) $adminsCount = 0;
echo $adminsCount;
foreach ($products as $product) {
    $totalProfit += $product->price * $product->numSold;
    $totalProductsStock += $product->stock;
    $totalSoldProducts += $product->numSold;
}
?>

<div class="dashboard-title">Dashboard</div>
<div class="dashboard-body">
    <div id="total-profit">Profit Income: <br> <span id="total-profit-val"><?php echo $totalProfit?>$</span></div>
    <div id="total-products">Total Number of Products: <br> <span id="total-products-val"><?php echo $productsNumber?></span></div>
    <div id="stock-products">Number of Products In Stock: <br> <span id="stock-products-val"><?php echo $totalProductsStock?></span></div>
    <div id="total-users">Users: <br> <span id="total-users-val"><?php echo $usersCount?></span></div>
    <div id="sold-products">Sold Products: <br> <span id="sold-products-val"><?php echo $totalSoldProducts?></span></div>

    <div id="total-admins">Admins: <br> <span id="total-admins-val"><?php echo $adminsCount?></span></div>
</div>

<?php include './components/admin-footer.php' ?>



</body>
</html>