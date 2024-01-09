<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <title>Profile</title>
    <script src="js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-light.css">
</head>
<body>
<?php include_once 'api/DBApi.php';
include_once 'api/generate/products.php';
include './components/navbar.php';
$user = DBApi::ensureLogin();
$isLogged = $user->username !== null;
$selectedCategory = "purchased";
$list = [];
if(!$isLogged) {
    echo "
        <script>
            $(() => {
                location.href = \"index.php\";
            });
        </script>
    ";
}

if($_SERVER['REQUEST_METHOD'] == 'GET' ){

    if(isset($_GET['tab'])){
        $selectedCategory = $_GET['tab'];

    }
    if($selectedCategory == 'purchased'){
        $list = $user->getPurchasedList();
    }elseif($selectedCategory == 'favorites'){
        $list = $user->getFavoritesList();
    }
}
?>


<div class="profile-body">
    <div class="info-card">
        <img src="/src/profile-img.jpg" alt="" class="profile-img">
        <div class="username"><?php echo $user->username?></div>
        <div class="email"><?php echo $user->email?></div>
        <button class="edit-profile" type="button" data-bs-toggle="modal" data-bs-target="#edit-data-modal">Edit Profile</button>
        <button class="logout-profile" type="button" id="logoutButton">Log out</button>
    </div>
    <div class="data-card">
        <ul class="sub-nav">
            <li <?php echo 'class="' . ($selectedCategory == "purchased" ? 'active"' : '"') ?> ><a  id="purchased-tab">Purchased</a></li>
            <li <?php echo 'class="' . ($selectedCategory == "favorites" ? 'active"' : '"') ?> ><a  id="favorites-tab" >Favorites</a></li>
        </ul>
        <div class="tabs-box">
            <div class="products-grid-view">
                <?php
                    generateCustomProducts($list);
                ?>
            </div>
        </div>
    </div>

</div>
<?php include './components/footer.php' ?>
<style>
    #footer {
        width: 100%;
    }
</style>


<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/profile-page.js"></script>

<script>
    $(() => {
       $("#logoutButton").click(function () {
           $.ajax({
               url: 'api/logout.php',
               method: 'POST',
               success: function(data) {
                   if(data === "success") {
                       location.href = "index.php";
                   }
               },
               error: function(error) {
                   console.log('Error:', error);
               }
           });
       });

       $("#purchased-tab").click(() => {
           let queryString = $.param({ tab: "purchased"});
           window.location.href = "profile-page.php?" + queryString;
       });

        $("#favorites-tab").click(() => {
            let queryString = $.param({ tab: "favorites"});
            window.location.href = "profile-page.php?" + queryString;
        });

    });
</script>
</body>
</html>