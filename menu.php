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
                    <button class="filter-btn active" data-filter="all">All Juices</button>
                    <button class="filter-btn" data-filter="detox">Detox</button>
                    <button class="filter-btn" data-filter="energy">Energy</button>
                    <button class="filter-btn" data-filter="immunity">Immunity</button>
                </div>
            </div>
            <div class="menu-hero-image" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1603569283847-aa295f0d016a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80" alt="Juice Selection">
            </div>
        </div>
    </section>

    <!-- Menu Section -->
  <?php
require_once 'db_connect.php';
$categories = [];
$foods = [];

$result = $conn->query("SELECT DISTINCT category FROM foods ORDER BY category");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}

$result = $conn->query("SELECT * FROM foods ORDER BY created_at DESC");
while ($row = $result->fetch_assoc()) {
    $foods[] = $row;
}
?>

<section class="full-menu">
    <div class="menu-container container">
        <?php foreach ($categories as $category): ?>
            <div class="menu-category" data-aos="fade-up">
                <h2 class="category-title"><?php echo htmlspecialchars($category); ?></h2>
                <p class="category-description">Explore our premium juices in the <?php echo htmlspecialchars($category); ?> category.</p>
                <div class="menu-items">
                    <?php foreach ($foods as $food): ?>
                        <?php if ($food['category'] === $category): ?>
                            <div class="menu-item" data-category="<?php echo htmlspecialchars(strtolower($category)); ?>">
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
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

            <div class="menu-category" data-aos="fade-up">
                <h2 class="category-title">Detox & Cleanses</h2>
                <p class="category-description">Purify your system with our nutrient-packed detox blends</p>
                <div class="menu-items">
                    <div class="menu-item" data-category="detox">
                        <div class="item-image">
                            <img src="https://images.unsplash.com/photo-1603569283847-aa295f0d016a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80" alt="Deep Cleanse">
                        </div>
                        <div class="item-info">
                            <h3>Deep Cleanse</h3>
                            <p class="item-description">Beetroot, carrot, apple, lemon & ginger</p>
                            <div class="item-footer">
                                <span class="item-price">$7.49</span>
                                <button class="add-to-cart" data-item="Deep Cleanse" data-price="7.49">
                                    <i class="fas fa-plus"></i> Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar">
        <div class="cart-header">
            <h3>Your Order</h3>
            <button class="close-cart"><i class="fas fa-times"></i></button>
        </div>
        <div class="cart-items">
            <!-- Cart items will be added here dynamically -->
        </div>
        <div class="cart-total">
            <span>Total:</span>
            <span class="total-price">$0.00</span>
        </div>
        <div class="cart-actions">
            <button class="checkout-btn">Proceed to Checkout</button>
            <button class="clear-cart">Clear Cart</button>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="payment-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1002;">
        <div class="payment-content" style="background: white; width: 400px; margin: 10% auto; padding: 2rem; border-radius: 10px; box-shadow: var(--box-shadow);">
            <h3 style="text-align: center; margin-bottom: 1.5rem;">Chappay Payment</h3>
            <p style="text-align: center; margin-bottom: 2rem;">Enter your payment code to complete the transaction.</p>
            <form id="payment-form">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Payment Code</label>
                    <input type="text" id="payment-code" style="width: 100%; padding: 1rem; border: 1px solid #eee; border-radius: 5px;" placeholder="e.g., CHAP1234" required>
                </div>
                <button type="submit" style="background: var(--bg-gradient); color: white; padding: 1rem 2rem; border: none; border-radius: 50px; width: 100%; cursor: pointer;">Pay Now</button>
            </form>
            <button class="close-payment" style="background: none; border: none; color: var(--text-light); font-size: 1.6rem; margin-top: 1rem; cursor: pointer; display: block; margin-left: auto;">Cancel</button>
        </div>
    </div>

    <div class="cart-overlay"></div>

    <!-- Order Button -->
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
                        <li><a href="#">Addis Ababa Juice Bar</a></li>
                    </ul>
                </div>
                <div class="footer-col" data-aos="fade-up" data-aos-delay="300">
                    <h4>Contact Info</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Juice Street, Addis Ababa</li>
                        <li><i class="fas fa-phone"></i> (555) 123-4567</li>
                        <li><i class="fas fa-envelope"></i> hello@juiceplus.com</li>
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

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="script.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const checkoutBtn = document.querySelector('.checkout-btn');
    const paymentModal = document.querySelector('.payment-modal');
    const closePaymentBtn = document.querySelector('.close-payment');
    const paymentForm = document.getElementById('payment-form');

    if (checkoutBtn && paymentModal && closePaymentBtn && paymentForm) {
        checkoutBtn.addEventListener('click', () => {
            if (cart.length > 0) {
                paymentModal.style.display = 'block';
            } else {
                alert('Your cart is empty!');
            }
        });

        closePaymentBtn.addEventListener('click', () => {
            paymentModal.style.display = 'none';
        });

        paymentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const paymentCode = document.getElementById('payment-code').value;
            if (paymentCode.toLowerCase() === 'chap1234') {
                const formData = new FormData();
                formData.append('action', 'place_order');
                formData.append('cart', JSON.stringify(cart));
                formData.append('total', cart.reduce((sum, item) => sum + item.price * item.quantity, 0));

                fetch('order_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        cart = [];
                        updateCart();
                        paymentModal.style.display = 'none';
                        paymentForm.reset();
                    }
                })
                .catch(() => alert('An error occurred.'));
            } else {
                alert('Invalid payment code.');
            }
        });
    }
});
</script>
</body>
</html>