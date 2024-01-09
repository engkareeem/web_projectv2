<?php
include_once 'api/DBApi.php';
$user = DBApi::ensureLogin();
if($user->isAdmin === true) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VectorZ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/product_view.js"></script>
    <script src="js/product.js"></script>
<!--   <script src="https://unpkg.com/@rive-app/canvas@2.7.0"></script>-->
    <script src="js/main.js"></script>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-light.css">

</head>
<body>
<?php

require_once 'api/generate/products.php';
include './components/navbar.php';
?>

    <div class="blue-circle"></div>
    <div class="blue-circle"></div>

<!--carousel-fade-->
    <div id="carouselSpecialOffers" class="carousel slide " data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselSpecialOffers" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselSpecialOffers" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselSpecialOffers" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselSpecialOffers" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/src/carousel/slide-1.jpg" class="d-block" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/src/carousel/slide-2.jpg" class="d-block" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/src/carousel/slide-3.jpg" class="d-block" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/src/carousel/slide-4.jpg" class="d-block" alt="...">
            </div>


        </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselSpecialOffers" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselSpecialOffers" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
    </div>



    <div class="cards-slide-label">
        <div class="title">Top Selling</div>
        <a class="see-more" href="all_products.php">See more</a>
    </div>
    <div id="top_selling_slider" class="cards-slide-container" >
        <button onclick="cards_slide_right(event)" class="arrow arrow-right fa-sharp fa-arrow-right"></button>
        <button onclick="cards_slide_left(event)" class="arrow arrow-left fa-sharp fa-arrow-left"></button>
        <div class="cards-container">
            <?php
            echo '<div class=\"spacer\"></div>';
                generateProducts([],['numSold'=>-1]);
            echo '<div class=\"spacer\"></div>';
            ?>
        </div>
    </div>

    <div class="cards-slide-label">
        <div class="title">Latest Offers</div>
        <a class="see-more" href="all_products.php">See more</a>
    </div>
    <div id="latest_offers_slider" class="cards-slide-container" >
        <button onclick="cards_slide_right(event)" class="arrow arrow-right fa-sharp fa-arrow-right"></button>
        <button onclick="cards_slide_left(event)" class="arrow arrow-left fa-sharp fa-arrow-left"></button>
        <div class="cards-container">
            <?php
            echo '<div class=\"spacer\"></div>';
                generateProducts([],['creationDate'=>-1]);
            echo '<div class=\"spacer\"></div>';
            ?>
        </div>
    </div>

    <div class="cards-slide-label">
        <div class="title">Best Deals</div>
        <a class="see-more" href="all_products.php">See more</a>
    </div>
    <div id="best_deals_slider" class="cards-slide-container" >
        <button onclick="cards_slide_right(event)" class="arrow arrow-right fa-sharp fa-arrow-right"></button>
        <button onclick="cards_slide_left(event)" class="arrow arrow-left fa-sharp fa-arrow-left"></button>
        <div class="cards-container">
            <?php
            echo '<div class=\"spacer\"></div>';
                generateProducts([],['discount'=>-1]);
            echo '<div class=\"spacer\"></div>';
            ?>
        </div>
    </div>

    <?php include 'components/footer.php' ?>


<!--<script src="js/generateTest.js"></script>-->
</body>
</html>