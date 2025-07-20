


<?php
require_once 'db_connect.php';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        
        $stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $success = 'Message sent successfully!';
        } else {
            $error = 'Failed to send message. Please try again.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Juice Plus+ | Premium Cold-Pressed Juices</title>
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
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
                <li><a href="admin.php" class="nav-cta">Admin</a></li>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>

    <!-- Contact Hero -->
    <section class="contact-hero">
        <div class="contact-hero-content container">
            <div class="contact-hero-text" data-aos="fade-right">
                <h1>Get in <span>Touch</span></h1>
                <p>Have questions, feedback, or special requests? We'd love to hear from you!</p>
                <div class="contact-info">
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>Call Us</h4>
                            <p>0939900633</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email Us</h4>
                            <p>abduJabez@gmail.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Visit Us</h4>
                            <p>Addis Ababa, Ethiopia</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-hero-image" data-aos="fade-left">
                <img src="images/contact.jpg" alt="Juice Bar">
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="contact-form-container container">
            <div class="form-header" data-aos="fade-up">
                <h2>Send Us a Message</h2>
                <p>Fill out the form below and we'll get back to you within 24 hours</p>
            </div>
            <form id="contact-form" class="contact-form" data-aos="fade-up" data-aos-delay="100" method="POST" action="contact.php">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>" required>
                    <i class="fas fa-tag"></i>
                </div>
                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" rows="5" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    <i class="fas fa-comment"></i>
                </div>
                <button type="submit" class="submit-btn">
                    <span>Send Message</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
                <div id="form-status" class="<?php echo $success ? 'success' : ($error ? 'error' : ''); ?>">
                    <?php echo $success ?: $error; ?>
                </div>
            </form>
        </div>
    </section>

    <!-- Locations Section -->
    <section class="locations">
        <div class="locations-container container">
            <div class="section-header" data-aos="fade-up">
                <h2>Our <span>Locations</span></h2>
                <p>Visit us at one of our premium juice bars</p>
            </div>
            <div class="location-cards">
                <div class="location-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="location-image">
                        <img src="images/zefmesh.jpg" alt="Zefmesh Grand Mall megenagna">
                    </div>
                    <div class="location-info">
                        <h3>Zefmesh Grand Mall megenagna</h3>
                        <p>Experience our premium juices in the heart of the city at Zefmesh Grand Mall.</p>
                        <p><i class="fas fa-phone"></i> 0939900633</p>
                        <p><i class="fas fa-envelope"></i> abduJabez@gmail.com</p>
                        <a href="https://mapcarta.com/W207342682" class="location-btn" target="_blank">Get Directions</a>
                    </div>
                </div>
                <div class="location-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="location-image">
                        <img src="images/amnassador.webp" alt="Ambasadar 4 killo">
                    </div>
                    <div class="location-info">
                        <h3>Ambasadar 4 killo</h3>
                        <p>Visit our flagship store at Ambasadar 4 killo for the ultimate juice experience.</p>
                        <p><i class="fas fa-phone"></i> 0939900633</p>
                        <p><i class="fas fa-envelope"></i> abduJabez@gmail.com</p>
                        <a href="https://www.google.com/maps/place/Merkato/@9.0331718,38.7144255,13.77z/data=!4m14!1m7!3m6!1s0x164b8565d4a30387:0x1cf0bebcc87aa5b2!2sShola+Market!8m2!3d9.0223515!4d38.7945519!16s%2Fg%2F11g_242lw!3m5!1s0x164b85e2aff5be9f:0xf3c31acfb90e54e3!8m2!3d9.0312054!4d38.7381822!16zL20vMGJ4NTd5?entry=ttu&g_ep=EgoyMDI1MDYyMi4wIKXMDSoASAFQAw%3D%3D" class="location-btn" target="_blank">Get Directions</a>
                    </div>
                </div>
                <div class="location-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="location-image">
                        <img src="images/handmade.jpg" alt="Handmade shola">
                    </div>
                    <div class="location-info">
                        <h3>Handmade shola</h3>
                        <p>Discover our artisanal juices at Handmade shola location.</p>
                        <p><i class="fas fa-phone"></i> 0939900633</p>
                        <p><i class="fas fa-envelope"></i> abduJabez@gmail.com</p>
                        <a href="https://www.google.com/maps/place/Shola+Market/@9.0173734,38.7853764,14.73z/data=!4m6!3m5!1s0x164b8565d4a30387:0x1cf0bebcc87aa5b2!8m2!3d9.0223515!4d38.7945519!16s%2Fg%2F11g_242lw?entry=ttu&g_ep=EgoyMDI1MDYyMi4wIKXMDSoASAFQAw%3D%3D" class="location-btn" target="_blank">Get Directions</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq">
        <div class="faq-container container">
            <div class="section-header" data-aos="fade-up">
                <h2>Frequently Asked <span>Questions</span></h2>
                <p>Find answers to common questions about Juice Plus+</p>
            </div>
            <div class="faq-accordion">
                <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                    <button class="accordion-header">
                        <span>What makes Juice Plus+ different from other juice bars?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <p>At Juice Plus+, we use only the highest quality organic ingredients and cold-press our juices to preserve maximum nutrients. Our unique blends are crafted by nutritionists to deliver specific health benefits, and we never add preservatives, artificial flavors, or sweeteners.</p>
                    </div>
                </div>
                <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                    <button class="accordion-header">
                        <span>How long do your juices stay fresh?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <p>Our cold-pressed juices stay fresh for up to 72 hours when refrigerated. For optimal freshness and nutrient retention, we recommend consuming them within 48 hours of purchase. All our bottles are clearly labeled with expiration dates.</p>
                    </div>
                </div>
                <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                    <button class="accordion-header">
                        <span>Do you offer juice cleanses or detox programs?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <p>Yes! We offer customized cleanse programs ranging from 1-day resets to 5-day deep cleanses. Our nutritionists can help you select the right program based on your goals and lifestyle. Visit any of our locations to learn more about our cleanse options.</p>
                    </div>
                </div>
                <div class="accordion-item" data-aos="fade-up" data-aos-delay="400">
                    <button class="accordion-header">
                        <span>Can I place an order for delivery or large events?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <p>Currently not available for delivery.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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
                        <li><a href="admin.php">Admin</a></li>
                    </ul>
                </div>
                <div class="footer-col" data-aos="fade-up" data-aos-delay="200">
                    <h4>Our Locations</h4>
                    <ul>
                        <li><a href="#">Zefmesh Grand Mall megenagna</a></li>
                        <li><a href="#">Ambasadar 4 killo</a></li>
                        <li><a href="#">Handmade shola</a></li>
                    </ul>
                </div>
                <div class="footer-col" data-aos="fade-up" data-aos-delay="300">
                    <h4>Contact Info</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Juice Street, Beverage City</li>
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

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JavaScript -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="script.js"></script>
</body>
</html>
