<?php
require_once('../helpers/session_config.php');
require_once('../server/submit_feedback.php');
// Debugging: Check if session variables are set
if (!isset($_SESSION['username'])) {
    // Optional: Redirect to login page if user is not logged in
    header('Location: ../public/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/628c8d2499.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../styles/home.css" type="text/css" />
    <link rel="stylesheet" href="../styles/nav.css" type="text/css" />
    <link rel="stylesheet" href="../styles/homeFooter.css" type="text/css" />
    <title>Home</title>
</head>

<body>
    <?php require_once('../common/homenav.html'); ?>

    <main id="top">
        <section id="home" class="section">
            <div class="container">
                <h1>Welcome to Our Store <span style="color:#f1c40f"><?= $_SESSION['username'] ?></span></h1>
                <p>Discover the latest in fashion and accessories for all genders and ages.</p>
            </div>

            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
            <div class="shape shape-6"></div>
            <div class="floating-shape shape-circle" style="top: 15%; left: 2%;"></div>
            <div class="floating-shape shape-square" style="bottom: 25%; right: 8%;"></div>
            <div class="floating-shape shape-triangle" style="top: 55%; left: 55%;"></div>
            <div class="floating-shape shape-hexagon" style="top: 35%; right: 25%;"></div>
            <div class="floating-shape shape-star" style="bottom: 45%; left: 20%;"></div>
            <div class="floating-shape shape-cross" style="top: 65%; right: 8%;"></div>
        </section>

        <section id="categories" class="section">
            <div class="container">
                <h2 class="section-title">Our Categories</h2>
                <p class="category-description" style="margin-bottom: 10px; font-size: 18px; font-weight: 500;">Explore
                    our diverse range of fashion categories, each offering a unique
                    style to suit your individual taste and needs.</p>
                <div class="category-cards">
                    <div class="category-card">
                        <img src="../data/imgs/Categories/MenCategory.jpeg" alt="Men Category">
                        <div class="card-content">
                            <h3><i class="fas fa-tshirt icon"></i> Men Category</h3>
                            <p>Unleash Your Inner Gentleman</p>
                            <a href="../public/menSection.php" class="cta-button">Learn More</a>
                        </div>
                    </div>
                    <div class="category-card">
                        <img src="../data/imgs/Categories/WomenCategory.jpeg" alt="Women Category">
                        <div class="card-content">
                            <h3><i class="fas fa-female icon"></i> Women Category</h3>
                            <p>Chic and Stylish Women's Wear</p>
                            <a href="../public/womenSection.php" class="cta-button">Learn More</a>
                        </div>
                    </div>
                    <div class="category-card">
                        <img src="../data/imgs/Categories/kidsCategory.jpeg" alt="Kids Category">
                        <div class="card-content">
                            <h3><i class="fas fa-child icon"></i> Kids Category</h3>
                            <p>Comfort and Style for Kids</p>
                            <a href="../public/kidsSection.php" class="cta-button">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="section">
            <div class="container">
                <h2 class="section-title">About Our Boutique</h2>
                <p class="section-description">At our fashion boutique, we believe that style is a form of
                    self-expression. We carefully curate our collections to bring you the latest trends and timeless
                    classics. Our mission is to empower you to look and feel your best, no matter the occasion. With a
                    focus on quality, sustainability, and individuality, we're here to help you craft your unique style
                    story.</p>
            </div>

            <div class="shape shape-1" style="left: -150px; top: -50px;"></div>
            <div class="shape shape-2" style="right: -150px; top: -50px;"></div>
            <div class="shape shape-3" style="left: -150px; bottom: -50px;"></div>
            <div class="shape shape-4" style="right: -150px; bottom: -50px;"></div>
            <div class="shape shape-5" style="top: -200px; left: -50px;"></div>
            <div class="shape shape-6" style="bottom: -200px; right: -50px;"></div>
            <div class="shape shape-6" style="bottom: -200px; right: -50px;"></div>
            <div class="floating-shape shape-circle" style="top: 15%; left: 2%;"></div>
            <div class="floating-shape shape-square" style="bottom: 25%; right: 8%;"></div>
            <div class="floating-shape shape-triangle" style="top: 55%; left: 55%;"></div>
            <div class="floating-shape shape-hexagon" style="top: 35%; right: 25%;"></div>
            <div class="floating-shape shape-star" style="bottom: 45%; left: 20%;"></div>
            <div class="floating-shape shape-cross" style="top: 65%; right: 8%;"></div>
        </section>

        <section id="services" class="section">
            <div class="container">
                <h2 class="section-title">Our Services</h2>
                <div class="service-list">
                    <div class="service-item">
                        <i class="fas fa-tshirt service-icon"></i>
                        <h3 class="service-title">Personal Styling</h3>
                        <p class="service-description">Our expert stylists are here to help you find the perfect look
                            for any occasion. Book a free consultation today.</p>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-cut service-icon"></i>
                        <h3 class="service-title">Custom Tailoring</h3>
                        <p class="service-description">Get the perfect fit with our in-house tailoring service. We
                            ensure your garments fit like a glove.</p>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-gift service-icon"></i>
                        <h3 class="service-title">Gift Cards</h3>
                        <p class="service-description">Give the gift of style with our customizable gift cards. Perfect
                            for birthdays, holidays, or any special occasion.</p>
                    </div>
                </div>
            </div>
        </section>


        <section id="contact" class="section">
            <div class="container">
                <h2 class="section-title">Contact Us</h2>
                <form class="contact-form" action="../public/home.php" method="POST">
                    <div class="form-group">
                        <label for="subject" class="form-label">Subject:</label>
                        <input type="text" id="subject" name="subject" class="form-input" placeholder="Subject"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="rating" class="form-label">Rating:</label>
                        <select id="rating" name="rating" class="form-input" required>
                            <option value="">Select Rating</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message" class="form-label">Message:</label>
                        <textarea id="message" name="message" class="form-input" placeholder="Your Message"
                            required></textarea>
                    </div>
                    <button type="submit" class="btn-53">
                        <div class="original">Submit</div>
                        <div class="letters">
                            <span>S</span>
                            <span>u</span>
                            <span>b</span>
                            <span>m</span>
                            <span>i</span>
                            <span>t</span>
                        </div>
                    </button>
                </form>
            </div>
        </section>
        



        <section id="Collection" class="collection-section section">
            <div class="collection-content">
                <h2 class="collection-title">Explore Our Collections</h2>
                <p class="collection-description">From casual chic to elegant eveningwear, our diverse collections cater
                    to every style and occasion. Discover the perfect pieces to express your unique personality and
                    elevate
                    your wardrobe.</p>
            </div>
            <div class="shape shape-1" style="left: -150px; top: -50px;"></div>
            <div class="shape shape-2" style="right: -150px; top: -50px;"></div>
            <div class="shape shape-3" style="left: -150px; bottom: -50px;"></div>
            <div class="shape shape-4" style="right: -150px; bottom: -50px;"></div>
            <div class="shape shape-5" style="top: -200px; left: -50px;"></div>
            <div class="shape shape-6" style="bottom: -200px; right: -50px;"></div>
            <div class="floating-shape shape-circle" style="top: 15%; left: 2%;"></div>
            <div class="floating-shape shape-square" style="bottom: 25%; right: 8%;"></div>
            <div class="floating-shape shape-triangle" style="top: 55%; left: 55%;"></div>
            <div class="floating-shape shape-hexagon" style="top: 35%; right: 25%;"></div>
            <div class="floating-shape shape-star" style="bottom: 45%; left: 20%;"></div>
            <div class="floating-shape shape-cross" style="top: 65%; right: 8%;"></div>

        </section>
    </main>


    <?php require_once('../common/insidefooter.html'); ?>
    <script src="../js/hamburgerMenu.js"></script>
    <script src="../js/home.js"></script>
</body>

</html>