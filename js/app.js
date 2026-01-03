// Core Application Logic

// --- Cart Management ---

function getCart() {
    const cart = localStorage.getItem('cart');
    return cart ? JSON.parse(cart) : [];
}

function saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
}

async function addToCart(productId) {
    // Requires fetching product details now
    const product = await fetchProductById(productId);

    if (!product) {
        alert("Product not found or Error connecting to server!");
        return;
    }

    let cart = getCart();
    const existingItem = cart.find(item => item.id == productId);

    if (existingItem) {
        existingItem.quantity += 1;
        alert(`${product.name} quantity updated in cart!`);
    } else {
        // Ensure price is a number
        product.price = parseFloat(product.price);
        cart.push({ ...product, quantity: 1 });
        alert(`${product.name} added to cart!`);
    }

    saveCart(cart);
}

function updateCartCount() {
    const cart = getCart();
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    const countElement = document.getElementById('cartCount');
    if (countElement) {
        countElement.textContent = count;
    }
}

// --- UI Rendering ---

function createProductCard(product) {
    const price = parseFloat(product.price).toFixed(2);
    const oldPrice = product.old_price ? parseFloat(product.old_price).toFixed(2) : null;

    // Note: Database uses 'old_price', JS used 'oldPrice'. We map it.

    return `
        <div class="product-card">
            <div class="product-image">
                <a href="product-details.html?id=${product.id}">
                    <img src="${product.image}" alt="${product.name}">
                </a>
            </div>
            <div class="product-info">
                <span class="product-category">${product.category}</span>
                <a href="product-details.html?id=${product.id}">
                    <h3 class="product-title">${product.name}</h3>
                </a>
                <div class="product-rating">
                    ${getStarRating(parseFloat(product.rating))}
                    <span>(${product.rating})</span>
                </div>
                <div class="product-price">
                    <span class="new-price">$${price}</span>
                    ${oldPrice ? `<span class="old-price">$${oldPrice}</span>` : ''}
                </div>
                <button class="add-to-cart-btn" onclick="addToCart(${product.id})">Add to Cart</button>
            </div>
        </div>
    `;
}

function getStarRating(rating) {
    const fullStars = Math.floor(rating);
    const halfStar = rating % 1 >= 0.5;
    let starsHtml = '';

    for (let i = 0; i < fullStars; i++) {
        starsHtml += '<i class="fas fa-star"></i>';
    }
    if (halfStar) {
        starsHtml += '<i class="fas fa-star-half-alt"></i>';
    }
    return starsHtml;
}

// Global initialization
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
});
