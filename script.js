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

    // Add to Cart
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const itemName = button.getAttribute('data-item');
            const itemPrice = parseFloat(button.getAttribute('data-price'));
            const itemImg = button.closest('.menu-item').querySelector('.item-image img').src;

            const existingItem = cart.find(item => item.name === itemName);
            if (existingItem) existingItem.quantity++;
            else cart.push({ name: itemName, price: itemPrice, quantity: 1, img: itemImg });

            updateCart();
        });
    });

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
    }

    // Clear Cart
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', () => {
            cart = [];
            updateCart();
        });
    }

    // Checkout with Payment Modal
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            if (cart.length > 0) {
                // Payment modal will handle the rest via updated script
            } else {
                alert('Your cart is empty!');
            }
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
    if (contactForm && formStatus) {
        contactForm.addEventListener('submit', e => {
            e.preventDefault();
            formStatus.textContent = 'Sending...';

            setTimeout(() => {
                formStatus.classList.add('success');
                formStatus.textContent = 'Message sent successfully!';
                contactForm.reset();
            }, 1000);
        });
    }

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
});
