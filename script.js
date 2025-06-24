document.addEventListener('DOMContentLoaded', () => {
    // Preloader
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        window.addEventListener('load', () => {
            preloader.style.opacity = '0';
            setTimeout(() => preloader.style.display = 'none', 500);
        });
    }
    
    
    // Hamburger Menu
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    }

    // Cart Functionality
    const cartBtn = document.querySelector('.cart-btn');
    const cartSidebar = document.querySelector('.cart-sidebar');
    const cartOverlay = document.querySelector('.cart-overlay');
    const closeCart = document.querySelector('.close-cart');
    const cartItemsContainer = document.querySelector('.cart-items');
    const cartTotal = document.querySelector('.total-price');
    const cartCount = document.querySelector('.cart-count');
    const clearCartBtn = document.querySelector('.clear-cart');
    const checkoutBtn = document.querySelector('.checkout-btn');
    const customerNameInput = document.getElementById('customer-name');
    const tableNumberInput = document.getElementById('table-number');
    const orderSuccessModal = document.getElementById('orderSuccessModal');
    const okBtn = document.getElementById('okBtn');
    let cart = [];

    if (cartBtn && cartSidebar && cartOverlay && closeCart) {
        cartBtn.addEventListener('click', () => {
            cartSidebar.classList.add('active');
            cartOverlay.classList.add('active');
        });

        closeCart.addEventListener('click', () => {
            cartSidebar.classList.remove('active');
            cartOverlay.classList.remove('active');
        });

        cartOverlay.addEventListener('click', () => {
            cartSidebar.classList.remove('active');
            cartOverlay.classList.remove('active');
        });
    }

    // Add to Cart (re-bind for dynamically rendered items)
    function bindAddToCartButtons() {
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.onclick = function() {
                const itemName = button.getAttribute('data-item');
                const itemPrice = parseFloat(button.getAttribute('data-price'));
                const itemImg = button.closest('.menu-item').querySelector('.item-image img').src;

                const existingItem = cart.find(item => item.name === itemName);
                if (existingItem) existingItem.quantity++;
                else cart.push({ name: itemName, price: itemPrice, quantity: 1, img: itemImg });

                updateCart();
                // Open cart sidebar
                if (cartSidebar && cartOverlay) {
                    cartSidebar.classList.add('active');
                    cartOverlay.classList.add('active');
                }
            };
        });
    }
    // Initial bind
    bindAddToCartButtons();
    // If menu items are filtered or re-rendered, call bindAddToCartButtons() again.

    // Update Cart Display
    function updateCart() {
        if (cartItemsContainer) {
            cartItemsContainer.innerHTML = '';
            let total = 0;
            let count = 0;

            cart.forEach((item, index) => {
                total += item.price * item.quantity;
                count += item.quantity;

                const cartItem = document.createElement('div');
                cartItem.classList.add('cart-item');
                cartItem.innerHTML = `
                    <div class="cart-item-img"><img src="${item.img}" alt="${item.name}"></div>
                    <div class="cart-item-details">
                        <h4>${item.name}</h4>
                        <div class="cart-item-price">$${item.price.toFixed(2)}</div>
                        <div class="cart-item-actions">
                            <button class="decrease">-</button>
                            <span class="cart-item-quantity">${item.quantity}</span>
                            <button class="increase">+</button>
                        </div>
                    </div>
                    <i class="fas fa-trash remove-item" data-index="${index}"></i>
                `;
                cartItemsContainer.appendChild(cartItem);
            });

            if (cartTotal) cartTotal.textContent = `$${total.toFixed(2)}`;
            if (cartCount) cartCount.textContent = count;

            // Re-bind listeners for new cart items
            bindCartItemButtons();
        }
        // Check button states after every cart update
        checkButtonStates();
    }

    function bindCartItemButtons() {
        document.querySelectorAll('.decrease').forEach(button => {
            button.addEventListener('click', () => {
                const index = button.closest('.cart-item').querySelector('.remove-item').getAttribute('data-index');
                if (cart[index].quantity > 1) cart[index].quantity--;
                else cart.splice(index, 1);
                updateCart();
            });
        });

        document.querySelectorAll('.increase').forEach(button => {
            button.addEventListener('click', () => {
                const index = button.closest('.cart-item').querySelector('.remove-item').getAttribute('data-index');
                cart[index].quantity++;
                updateCart();
            });
        });

        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', () => {
                const index = button.getAttribute('data-index');
                cart.splice(index, 1);
                updateCart();
            });
        });
    }

    function checkButtonStates() {
        const nameValid = customerNameInput && customerNameInput.value.trim() !== '';
        const tableValid = tableNumberInput && tableNumberInput.value.trim() !== '';
        const cartHasItems = cart.length > 0;

        if (checkoutBtn) {
            checkoutBtn.disabled = !(nameValid && tableValid && cartHasItems);
        }
        if (clearCartBtn) {
            clearCartBtn.disabled = !cartHasItems;
        }
    }

    // Add event listeners for the input fields
    if (customerNameInput) customerNameInput.addEventListener('input', checkButtonStates);
    if (tableNumberInput) tableNumberInput.addEventListener('input', checkButtonStates);

    // Clear Cart
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', () => {
            cart = [];
            if(customerNameInput) customerNameInput.value = '';
            if(tableNumberInput) tableNumberInput.value = '';
            updateCart();
        });
    }

    // Checkout
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            if (!checkoutBtn.disabled) {
                // Gather order data
                const customerName = customerNameInput.value.trim();
                const tableNumber = tableNumberInput.value.trim();
                const totalAmount = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
                const items = cart.map(item => ({ name: item.name, price: item.price, quantity: item.quantity }));
                // Send to save_order.php
                fetch('save_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        customer_name: customerName,
                        table_number: tableNumber,
                        total_amount: totalAmount,
                        items: items
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (orderSuccessModal) orderSuccessModal.classList.add('active');
                    } else {
                        showAdminMessage(data.message || 'Failed to save order.', 'error');
                    }
                })
                .catch(() => {
                    showAdminMessage('Failed to save order.', 'error');
                });
            }
        });
    }

    // OK button on success modal
    if (okBtn) {
        okBtn.addEventListener('click', () => {
            // Hide modal
            if (orderSuccessModal) orderSuccessModal.classList.remove('active');

            // Close cart sidebar
            if (cartSidebar && cartOverlay) {
                cartSidebar.classList.remove('active');
                cartOverlay.classList.remove('active');
            }

            // Clear cart, inputs, and update UI
            cart = [];
            if(customerNameInput) customerNameInput.value = '';
            if(tableNumberInput) tableNumberInput.value = '';
            updateCart();
        });
    }

    // Menu Filter
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelector('.filter-btn.active').classList.remove('active');
            button.classList.add('active');

            const filter = button.getAttribute('data-filter');
            document.querySelectorAll('.menu-item').forEach(item => {
                item.style.display = filter === 'all' || item.getAttribute('data-category') === filter ? 'block' : 'none';
            });
        });
    });

    // Testimonial Slider
    const sliderPrev = document.querySelector('.slider-prev');
    const sliderNext = document.querySelector('.slider-next');
    const sliderDots = document.querySelectorAll('.slider-dot');
    const slides = document.querySelectorAll('.testimonial-slide');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? 'block' : 'none';
            sliderDots[i].classList.toggle('active', i === index);
        });
        currentSlide = index;
    }

    if (sliderPrev && sliderNext && slides.length > 0) {
        sliderPrev.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        });

        sliderNext.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        });

        sliderDots.forEach((dot, i) => dot.addEventListener('click', () => showSlide(i)));
        showSlide(0);
    }

    // Contact Form
    const contactForm = document.getElementById('contact-form');
    const formStatus = document.getElementById('form-status');
    // Remove the JS submit handler to allow default PHP form submission

    // FAQ Accordion
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const isActive = header.classList.contains('active');

            document.querySelectorAll('.accordion-header').forEach(h => {
                h.classList.remove('active');
                h.nextElementSibling.style.maxHeight = null;
            });

            if (!isActive) {
                header.classList.add('active');
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });
    });

    // Back to Top Button
    const backToTop = document.querySelector('.back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', () => backToTop.classList.toggle('active', window.scrollY > 500));
        backToTop.addEventListener('click', e => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Initialize AOS
    if (typeof AOS !== 'undefined') AOS.init({ duration: 800, once: true, offset: 100 });

    // Add a showAdminMessage function if not present
    function showAdminMessage(msg, type = 'info') {
        let adminMessage = document.getElementById('adminMessage');
        if (!adminMessage) {
            adminMessage = document.createElement('div');
            adminMessage.id = 'adminMessage';
            adminMessage.style.position = 'fixed';
            adminMessage.style.top = '0';
            adminMessage.style.left = '0';
            adminMessage.style.width = '100%';
            adminMessage.style.zIndex = '9999';
            adminMessage.style.textAlign = 'center';
            adminMessage.style.fontWeight = '600';
            adminMessage.style.padding = '1.2rem 0';
            document.body.prepend(adminMessage);
        }
        adminMessage.textContent = msg;
        adminMessage.style.display = 'block';
        adminMessage.style.background = type === 'error' ? 'rgba(255,107,107,0.12)' : 'rgba(78,205,196,0.10)';
        adminMessage.style.color = type === 'error' ? '#ff6b6b' : '#4ecdc4';
        setTimeout(() => { adminMessage.style.display = 'none'; }, 3500);
    }
});