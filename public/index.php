<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/nav.css">
    <link rel="stylesheet" href="../styles/index.css">
    <title>E_commerce</title>
</head>

<body>
    <?php require_once ('../common/nav.html') ?>
</body>
<div class="container">
    <div class="jumbotron jumbotron-fluid bg-transparent">
  <h1 class="display-4">Welcome to our E-commerce website!</h1>
  <p class="lead">Explore our wide range of products and find great deals.</p>
  <hr class="my-4">
  <p class="lead">Get started by registering or logging in to access our exclusive offers and discounts!</p>
</div> 
    <div class="row">
        <div class="col-md-4">
            <div class="info-card card1">
                <img src="../data/imgs/SpecialOffers.jpg" alt="Image 1" class="img-fluid">
                <div class="breaker-line"></div>
                <h2>Deals of the Day</h2>
                <p>Check out our daily deals and discounts on various products.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card card2">
                <img src="../data/imgs/TopBrands.jpg" alt="Image 2" class="img-fluid">
                <div class="breaker-line"></div>
                <h2>Top Brands</h2>
                <p>Shop from our collection of top brands and products.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card card3">
                <img src="../data/imgs/customerExp.jpeg" alt="Image 3" class="img-fluid">
                <div class="breaker-line"></div>
                <h2>Customer Experience</h2>
                <p>Read what our satisfied customers have to say about us.</p>
            </div>
        </div>
    </div>
</div>

</body>
<?php require_once ('../common/footer.html') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</html>