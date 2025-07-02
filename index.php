<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juice Plus - Premium Juice Experience</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <nav class="nav container">
            <div class="logo" data-aos="fade-down">Juice <span class="plus-glow">Plus+</span></div>
            <ul class="nav-links" data-aos="fade-down">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="#" class="nav-cta">Order Now</a></li>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="hero-content container">
            <div class="hero-text">
                <h1 class="hero-title">
                    <span class="staggered-word">Premium</span>
                    <span class="staggered-word">Cold-Pressed</span>
                    <span class="staggered-word">Juices</span>
                </h1>
                <p class="hero-subtitle">
                    Where <span class="highlight-text">nature meets innovation</span> - Experience the ultimate fusion of exotic fruits, superfoods, and unparalleled freshness
                </p>
                <div class="hero-buttons">
                    <a href="menu.php" class="hero-btn primary-btn">Explore Menu</a>
                    <a href="about.php" class="hero-btn secondary-btn">
                        <i class="fas fa-info-circle"></i> About Us
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">250+</span>
                        <span class="stat-label">Happy Customers</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Unique Flavors</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Organic</span>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <div class="juice-bottle">
                    <img src="images/homepage.webp" alt="Premium Juice">
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about" id="about">
        <div class="about-content container">
            <div class="about-text" data-aos="fade-right">
                <h2 class="section-title">About <span class="highlight-text">Juice Plus+</span></h2>
                <p class="section-description">Founded in 2020, Juice Plus+ is dedicated to bringing the freshest, most nutrient-packed juices to our community. Our mission is to promote wellness through nature's finest ingredients, crafted with care and innovation.</p>
                <div class="about-values">
                    <div class="value-item">
                        <i class="fas fa-leaf"></i>
                        <h4>100% Organic</h4>
                        <p>We source only the highest quality organic fruits and vegetables.</p>
                    </div>
                    <div class="value-item">
                        <i class="fas fa-flask"></i>
                        <h4>Cold-Pressed</h4>
                        <p>Our unique process preserves maximum nutrients and flavor.</p>
                    </div>
                    <div class="value-item">
                        <i class="fas fa-heart"></i>
                        <h4>Community Focused</h4>
                        <p>We support local farmers and sustainable practices.</p>
                    </div>
                </div>
                <a href="about.php" class="hero-btn primary-btn">Learn More</a>
            </div>
            <div class="about-image" data-aos="fade-left">
                <img src="images/photo_2025-06-12_10-04-13.jpg" alt="About Juice Plus">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-content container">
            <h2 class="section-title">Why Choose <span class="highlight-text">Us</span></h2>
            <p class="section-description">Discover what makes Juice Plus+ the ultimate choice for health-conscious juice lovers.</p>
            <div class="feature-cards">
                <div class="feature-card" data-aos="fade-up">
                    <div class="card-icon"><i class="fas fa-seedling"></i></div>
                    <h3>Organic Ingredients</h3>
                    <p>Sourced from trusted local farms, our ingredients are free from pesticides and chemicals.</p>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-icon"><i class="fas fa-tint"></i></div>
                    <h3>Cold-Pressed Process</h3>
                    <p>Our juices retain maximum nutrients through a gentle, cold-press extraction method.</p>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-icon"><i class="fas fa-leaf"></i></div>
                    <h3>Sustainable Practices</h3>
                    <p>We prioritize eco-friendly packaging and support sustainable agriculture.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="testimonials-content container">
            <h2 class="section-title">What Our <span class="highlight-text">Customers Say</span></h2>
            <p class="section-description">Hear from our happy customers who love our premium juices.</p>
            <div class="testimonial-slider">
                <div class="testimonial-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"ጁስ ፕላስ ህይወቴን ለውጦታል .. ካየሁት ካፌዎች ሁሉ የተለየ ነው።"</p>
                        <div class="testimonial-author">
                            <img src="images/chaltu.jpg" alt="Customer">
                            <div>
                                <h4>Chaltu Abebe.</h4>
                                <span>Health Enthusiast</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-text">"ለስፓርተኞች እና ለአጠቃላይ ጤናማ ምግብ ፈላጊዎች በሙሉ ይሄንን ቤት Highly Recommend አደርጋችዋለው።"</p>
                        <div class="testimonial-author">
                            <img src="images/Alex.jpg" alt="Customer">
                            <div>
                                <h4>Alemayhu Negatu</h4>
                                <span>Fitness Coach</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-controls">
                <button class="slider-prev"><i class="fas fa-chevron-left"></i></button>
                <div class="slider-dots">
                    <span class="slider-dot active"></span>
                    <span class="slider-dot"></span>
                </div>
                <button class="slider-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <!-- CTA Section nw -->
    <section class="cta" id="cta">
        <div class="cta-content container">
            <div class="cta-text" data-aos="fade-right">
                <h2>Ready to Taste the Difference?</h2>
                <p>Join the Juice Plus+ community and enjoy premium juices delivered fresh to your door.</p>
            </div>
            <div class="cta-form" data-aos="fade-left">
                <a href="menu.php" class="hero-btn primary-btn">Order Now</a>
            </div>
        </div>
    </section>

    <!-- Footer  nw -->
    <footer class="footer">
        <div class="footer-content container">
            <div class="footer-main">
                <div class="footer-col" data-aos="fade-up">
                    <div class="footer-logo">Juice <span>Plus+</span></div>
                    <p class="footer-about">Premium cold-pressed juices crafted with organic ingredients to nourish your body and delight your taste buds.</p>
                    <div class="footer-social">
                        <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://instagram.com" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://tiktok.com" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="footer-col" data-aos="fade-up" data-aos-delay="100">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="menu.php">Our Menu</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-col" data-aos="fade-up" data-aos-delay="200">
                    <h4>Our Locations</h4>
                    <ul>
                        <li><a href="#">Addis Ababa Juice Bar</a></li>
                    </ul>
                </div>
                <div class="footer-col" data-aos="fade-up" data-aos-delay="300">
                    <h4>Contact Info</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Juice Street, Addis Ababa</li>
                        <li><i class="fas fa-phone"></i> 0939900633</li>
                        <li><i class="fas fa-envelope"></i> abduJabez@gmail.com</li>
                        <li><i class="fas fa-clock"></i> Mon-Sat: 7am-7pm, Sun: 8am-5pm</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2025 Juice Plus+. All rights reserved.</p>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button nw -->
    <a href="#" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JavaScript link madreg -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="script.js"></script>
</body>
</html>