<?php
require_once 'db_connect.php';
$categories = [];
$foods = [];
$result = $conn->query("SELECT DISTINCT category FROM foods ORDER BY category");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
    }
}
$result = $conn->query("SELECT * FROM foods ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $foods[] = $row;
    }
}
function category_slug($name) {
    return strtolower(preg_replace('/[^a-z0-9]+/', '-', trim($name)));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juice Plus+ Menu | Premium Cold-Pressed Juices</title>
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
                <li><a href="menu.php" class="active">Menu</a></li>
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

    <!-- Menu Hero -->
    <section class="menu-hero">
        <div class="menu-hero-content container">
            <div class="menu-hero-text" data-aos="fade-right">
                <h1>Our Premium <span>Juice Menu</span></h1>
                <p>Explore our selection of cold-pressed, nutrient-rich juices crafted to energize, detoxify, and nourish your body.</p>
                <div class="menu-filter-buttons">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <?php foreach ($categories as $category): ?>
                        <button class="filter-btn" data-filter="<?php echo category_slug($category); ?>">
                            <?php echo htmlspecialchars($category); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="menu-hero-image" data-aos="fade-left">
                <img src="images/burger and juice.avif" alt="Juice Selection">
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="full-menu">
        <div class="menu-container container">
            <?php if (count($foods) > 0): ?>
            <div class="menu-items">
            <?php foreach ($foods as $food): ?>
                <div class="menu-item" data-category="<?php echo category_slug($food['category']); ?>">
                    <div class="item-image">
                        <img src="<?php echo htmlspecialchars($food['image'] ?: 'https://images.unsplash.com/photo-1603569283847-aa295f0d016a?auto=format&fit=crop&w=880&q=80'); ?>" alt="<?php echo htmlspecialchars($food['name']); ?>">
                        <?php if ($food['badge']): ?>
                            <div class="item-badge <?php echo htmlspecialchars(strtolower($food['badge'])); ?>"><?php echo htmlspecialchars($food['badge']); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="item-info">
                        <h3><?php echo htmlspecialchars($food['name']); ?></h3>
                        <p class="item-description"><?php echo htmlspecialchars($food['description']); ?></p>
                        <div class="item-footer">
                            <span class="item-price">$<?php echo number_format($food['price'], 2); ?></span>
                            <button class="add-to-cart" data-item="<?php echo htmlspecialchars($food['name']); ?>" data-price="<?php echo $food['price']; ?>">
                                <i class="fas fa-plus"></i> Order
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <div class="no-items-message" style="display:none; text-align:center; color:#ff6b6b; font-size:1.3rem; margin-top:2rem;">No items in this category.</div>
            <?php else: ?>
            <div class="no-foods">No food items available. Please check back later!</div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar">
        <div class="cart-header">
            <h3>Your Order</h3>
            <button class="close-cart"><i class="fas fa-times"></i></button>
        </div>
        <div class="cart-items"><!-- Cart items will be added here dynamically --></div>
        <div class="cart-total">
            <span>Total:</span>
            <span class="total-price">$0.00</span>
        </div>
        <div class="cart-table-number" style="padding: 1rem 2rem; display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <label for="customer-name" style="font-weight: 600;">Enter Name</label>
                <input type="text" id="customer-name" maxlength="50" placeholder="e.g. John Doe" style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #eee; font-size: 1.2rem; margin-top: 0.5rem;" autocomplete="off">
            </div>
            <div>
                <label for="table-number" style="font-weight: 600;">Enter Table Number</label>
                <input type="text" id="table-number" maxlength="2" pattern="\d{2}" placeholder="e.g. 12" style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #eee; font-size: 1.2rem; margin-top: 0.5rem;" autocomplete="off">
            </div>
        </div>
        <div class="cart-actions">
            <button class="checkout-btn" disabled>Proceed to Checkout</button>
            <button class="clear-cart" disabled>Clear Menu</button>
        </div>
        <div class="order-message" style="display:none; text-align:center; margin: 2rem 0 0 0;"></div>
    </div>
    <div class="cart-overlay"></div>

    <!-- Order Success Modal -->
    <div class="order-success-modal" id="orderSuccessModal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Order Placed!</h2>
            <p>Your order is on its way. Relax and have fun, we'll bring it to your table shortly!</p>
            <button class="ok-btn" id="okBtn">OK</button>
        </div>
    </div>

    <!-- Cart Button -->
    <button class="cart-btn">
        <i class="fas fa-utensils"></i>
        <span class="cart-count">0</span>
    </button>

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
                    </ul>
                </div>
                <div class="footer-col" data-aos="fade-up" data-aos-delay="200">
                    <h4>Our Locations</h4>
                    <ul>
                        <li><a href="contact.php">Addis Ababa Juice Bar</a></li>
                    </ul>
                </div>
                <div class="footer-col" data-aos="fade-up" data-aos-delay="300">
                    <h4>Contact Info</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> 3 branches, Addis Ababa</li>
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
    <a href="#" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </a>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="script.js"></script>
</body>
</html>