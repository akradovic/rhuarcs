// assets/js/src/index.js
import { initializeFilters } from './modules/filters';
import { initializeMobileNav } from './modules/mobileNav';
import { initializeProductGrid } from './modules/productGrid';
import { initializeCart } from './modules/cart';

document.addEventListener('DOMContentLoaded', () => {
    initializeMobileNav();
    initializeFilters();
    initializeProductGrid();
    initializeCart();
});

// assets/js/src/modules/mobileNav.js
export function initializeMobileNav() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');
    const overlay = document.querySelector('.mobile-menu-overlay');

    if (!mobileMenuBtn || !mobileMenu) return;

    mobileMenuBtn.addEventListener('click', () => {
        const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
        mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
        mobileMenu.classList.toggle('translate-x-0');
        mobileMenu.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    });

    // Close menu when clicking overlay
    overlay?.addEventListener('click', () => {
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        mobileMenu.classList.remove('translate-x-0');
        mobileMenu.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

// assets/js/src/modules/filters.js
export function initializeFilters() {
    const filterForm = document.querySelector('.product-filters');
    if (!filterForm) return;

    const filterInputs = filterForm.querySelectorAll('input[type="checkbox"], select');
    const productGrid = document.querySelector('.product-grid');
    const loadingOverlay = document.querySelector('.loading-overlay');

    filterInputs.forEach(input => {
        input.addEventListener('change', async () => {
            loadingOverlay?.classList.remove('hidden');

            const formData = new FormData(filterForm);
            const searchParams = new URLSearchParams(formData);

            try {
                const response = await fetch(`${rhuarcsData.ajaxUrl}?action=filter_products&${searchParams.toString()}`);
                const data = await response.json();

                if (data.success && productGrid) {
                    productGrid.innerHTML = data.html;
                    // Update URL with filters
                    window.history.pushState({}, '', `?${searchParams.toString()}`);
                }
            } catch (error) {
                console.error('Error filtering products:', error);
            } finally {
                loadingOverlay?.classList.add('hidden');
            }
        });
    });
}

// assets/js/src/modules/productGrid.js
export function initializeProductGrid() {
    const productGrid = document.querySelector('.product-grid');
    if (!productGrid) return;

    // Initialize infinite scroll if enabled
    if (productGrid.dataset.infiniteScroll === 'true') {
        let page = 1;
        let loading = false;

        window.addEventListener('scroll', async () => {
            if (loading) return;

            const lastProduct = productGrid.lastElementChild;
            const lastProductOffset = lastProduct.offsetTop + lastProduct.clientHeight;
            const pageOffset = window.pageYOffset + window.innerHeight;

            if (pageOffset > lastProductOffset - 20) {
                loading = true;
                page++;

                try {
                    const response = await fetch(`${rhuarcsData.ajaxUrl}?action=load_more_products&page=${page}`);
                    const data = await response.json();

                    if (data.success) {
                        productGrid.insertAdjacentHTML('beforeend', data.html);
                        loading = false;
                    }
                } catch (error) {
                    console.error('Error loading more products:', error);
                    loading = false;
                }
            }
        });
    }
}

// assets/js/src/modules/cart.js
export function initializeCart() {
    const cartButtons = document.querySelectorAll('.add-to-cart');
    const cartCount = document.querySelector('.cart-count');
    const cartTotal = document.querySelector('.cart-total');

    cartButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = button.dataset.productId;
            const quantity = button.closest('form')?.querySelector('input[name="quantity"]')?.value || 1;

            try {
                const response = await fetch(rhuarcsData.ajaxUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'add_to_cart',
                        product_id: productId,
                        quantity: quantity,
                        nonce: rhuarcsData.nonce
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Update cart count and total
                    if (cartCount) cartCount.textContent = data.cartCount;
                    if (cartTotal) cartTotal.textContent = data.cartTotal;

                    // Show success message
                    showNotification('Product added to cart!', 'success');
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                showNotification('Failed to add product to cart', 'error');
            }
        });
    });
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 p-4 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white transform translate-y-0 opacity-100 transition-all duration-300`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('translate-y-full', 'opacity-0');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}