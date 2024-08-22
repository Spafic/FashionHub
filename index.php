<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub - Discover Your Style</title>
    <link rel="stylesheet" href="./Styles/index.css">
    <link rel="stylesheet" href="./Styles/nav.css">
    <link rel="stylesheet" href="./Styles/homeFooter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php require_once "./common/indexnav.html" ?>
    <div class="cloud-bg"></div>
    <div class="rain"></div>

    <div id="home" class="section hero">
        <div class="container">
            <h1>FashionHub</h1>
            <p class="lead">Discover your style and elevate your wardrobe.</p>
            <div class="cta-buttons">
                <a href="../public/register.php" class="cta-button primary">
                    <i class="fas fa-rocket icon"></i> Get Started
                </a>
                <a href="../public/login.php" class="cta-button primary">
                    <i class="fas fa-lock icon"></i> Login
                </a>
            </div>
        </div>
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
        <div class="shape shape-5"></div>
        <div class="shape shape-6"></div>
        <div class="floating-shape shape-circle" style="top: 10%; left: 5%;"></div>
        <div class="floating-shape shape-square" style="bottom: 20%; right: 10%;"></div>
        <div class="floating-shape shape-triangle" style="top: 50%; left: 50%;"></div>
        <div class="floating-shape shape-hexagon" style="top: 30%; right: 20%;"></div>
        <div class="floating-shape shape-star" style="bottom: 40%; left: 15%;"></div>
        <div class="floating-shape shape-cross" style="top: 60%; right: 5%;"></div>
        <div class="shape-wave"></div>
        <div class="shape-curved"></div>
        <div class="shape-polygon"></div>
        <div class="shape-overlapping-circles"></div>
        <div class="shape-distorted"></div>
    </div>

    <div id="categories" class="section categories fade-in">
        <div class="container">
            <h2>Our Categories</h2>
            <div class="category-cards">
                <div class="category-card">
                    <img src="./data/imgs/CasualWear.jpeg" alt="Casual Wear" class="fit-image">
                    <div class="card-content">
                        <h3><i class="fas fa-tshirt icon"></i> Casual Wear</h3>
                        <p>Comfortable and stylish outfits for everyday wear.</p>
                    </div>
                </div>
                <div class="category-card">
                    <img src="./data/imgs/FormalWear.jpeg" alt="Formal Wear" class="fit-image">
                    <div class="card-content">
                        <h3><i class="fas fa-user-tie icon"></i> Formal Wear</h3>
                        <p>Elegant attire for business and formal events.</p>
                    </div>
                </div>
                <div class="category-card">
                    <img src="./data/imgs/SportsWear.jpeg" alt="Sports Wear" class="fit-image">
                    <div class="card-content">
                        <h3><i class="fas fa-running icon"></i> Sportswear</h3>
                        <p>Performance gear for all your athletic activities.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="floating-shape shape-circle" style="top: 70%; right: 15%;"></div>
    </div>

    <div id="testimonials" class="section testimonials fade-in">
        <div class="container">
            <h2>What Our Customers Say</h2>
            <div class="testimonial-slider">
                <div class="testimonial-container">
                    <div class="testimonial">
                        <p>"FashionHub has completely changed my wardrobe. I love the variety and quality!"</p>
                        <span class="customer-name">- Sarah J.</span>
                    </div>
                    <div class="testimonial">
                        <p>"The best online shopping experience I've ever had. Highly recommend!"</p>
                        <span class="customer-name">- Mike T.</span>
                    </div>
                    <div class="testimonial">
                        <p>"Amazing customer service and fast delivery. I'm a loyal customer for life!"</p>
                        <span class="customer-name">- Lisa K.</span>
                    </div>
                    <div class="testimonial">
                        <p>"FashionHub is my go-to for all things fashion. I can't get enough!"</p>
                        <span class="customer-name">- John D.</span>
                    </div>
                    <div class="testimonial">
                        <p>"I've never been more satisfied with my purchases. FashionHub is the best!"</p>
                        <span class="customer-name">- Emily S.</span>
                    </div>
                    <div class="testimonial">
                        <p>"The quality of the products is unmatched. I'm a customer for life!"</p>
                        <span class="customer-name">- Alex M.</span>
                    </div>
                    <div class="testimonial">
                        <p>"FashionHub has the best selection of clothing and accessories. Love it!"</p>
                        <span class="customer-name">- Jessica L.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="floating-shape shape-square" style="bottom: 10%; left: 5%;"></div>
    </div>

    <div id="trending" class="section trending fade-in">
        <div class="container">
            <h2>Trending Now</h2>
            <div class="trending-items">
                <div class="trending-item">
                    <img src="./data/imgs/SummerCollection.jpeg" alt="Summer Collection" class="fit-image">
                    <div class="card-content">
                        <h3><i class="fas fa-sun icon"></i> Summer Collection</h3>
                        <p>Beat the heat with our cool summer styles.</p>
                    </div>
                </div>
                <div class="trending-item">
                    <img src="./data/imgs/Accessories.jpeg" alt="Accessories" class="fit-image">
                    <div class="card-content">
                        <h3><i class="fas fa-gem icon"></i> Accessories</h3>
                        <p>Complete your look with our trendy accessories.</p>
                    </div>
                </div>
                <div class="trending-item">
                    <img src="./data/imgs/NewArrival.jpeg" alt="New Arrival" class="trending-image">
                    <div class="card-content">
                        <h3><i class="fas fa-star icon"></i> New Arrival</h3>
                        <p>Explore our newest collection that just landed!</p>
                    </div>

                </div>
            </div>

            <div class="floating-shape shape-triangle" style="top: 20%; right: 10%;"></div>
        </div>
    </div>

    <div id="about" class="section about fade-in" style="margin-top: auto !important;">
        <div class="container">
            <h2>About FashionHub</h2>
            <p class="lead">We're passionate about bringing you the latest trends and timeless classics.</p>
            <div class="about-content">
                <div class="about-item">
                    <i class="fas fa-heart icon"></i>
                    <h3>Quality First</h3>
                    <p>We source only the best materials for our products.</p>
                </div>
                <div class="about-item">
                    <i class="fas fa-globe icon"></i>
                    <h3>Global Trends</h3>
                    <p>Stay up-to-date with international fashion movements.</p>
                </div>
                <div class="about-item">
                    <i class="fas fa-users icon"></i>
                    <h3>Customer Focus</h3>
                    <p>Your satisfaction is our top priority.</p>
                </div>
            </div>
        </div>
        <div class="floating-shape shape-circle" style="bottom: 15%; left: 20%;"></div>
    </div>

    <script src="./js/index.js"></script>
    <script src="./js/hamburgerMenu.js"></script>
    <?php require_once "./common/insidefooter.html" ?>
</body>

</html>