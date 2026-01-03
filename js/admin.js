// JS/Admin.js - Refactored for API

const API_Base = '../api';

function checkAuth() {
    return localStorage.getItem('isAdmin') === 'true';
}

async function login(username, password) {
    try {
        const response = await fetch(`${API_Base}/login.php`, {
            method: 'POST',
            body: JSON.stringify({ username, password })
        });
        const data = await response.json();

        if (data.status === 'success') {
            localStorage.setItem('isAdmin', 'true');
            return true;
        }
        return false;
    } catch (e) {
        console.error(e);
        return false;
    }
}

function logout() {
    localStorage.removeItem('isAdmin');
    window.location.href = 'login.html';
}

// Product Management

async function getAdminProducts() {
    try {
        const response = await fetch(`${API_Base}/products.php`);
        return await response.json();
    } catch (e) {
        console.error(e);
        return [];
    }
}

async function addProduct(product) {
    // Implementation for Add not fully provided in PHP API in plan, 
    // but assuming user can extend. For now, we will add an add_product.php endpoint logic here or mock it?
    // User asked to connect phpmyadmin, implying full CRUD.
    // I need to create add_product.php but didn't in previous step. 
    // I will assume for this step, I will add it or use a generic one.
    // Let's create `api/add_product.php` in next step.

    try {
        const response = await fetch(`${API_Base}/add_product.php`, {
            method: 'POST',
            body: JSON.stringify(product)
        });
        const data = await response.json();
        if (data.status === 'success') {
            alert('Product Added!');
            window.location.reload();
        } else {
            alert('Error adding product');
        }
    } catch (e) {
        console.error(e);
        alert('Error connecting to server');
    }
}

async function deleteProduct(id) {
    if (!confirm('Are you sure you want to delete this product?')) return;

    try {
        const response = await fetch(`${API_Base}/delete_product.php`, {
            method: 'POST',
            body: JSON.stringify({ id })
        });
        // We will need to create this API too
        const data = await response.json();
        if (data.status === 'success') {
            alert('Product Deleted!');
            renderAdminProducts();
        } else {
            alert('Error deleting product');
        }
    } catch (e) {
        console.error(e);
    }
}


// UI Rendering Functions for Dashboard
async function renderAdminProducts() {
    const tbody = document.getElementById('productTableBody');
    if (!tbody) return;

    const products = await getAdminProducts();
    if (!products || products.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6">No products found.</td></tr>';
        return;
    }

    tbody.innerHTML = products.map(p => `
        <tr>
            <td>${p.id}</td>
            <td><img src="../${p.image}" width="50"></td>
            <td>${p.name}</td>
            <td>$${parseFloat(p.price).toFixed(2)}</td>
            <td>${p.category}</td>
            <td>
                <button class="btn-sm btn-danger" onclick="deleteProduct(${p.id})">Delete</button>
            </td>
        </tr>
    `).join('');
}

// Order Management (Incomplete in API - assuming we need api/orders_list.php)
// For now, let's stick to simple or create that API
async function renderOrders() {
    // Placeholder - we didn't create get_orders API yet. 
    // Use LocalStorage as fallback or leave empty?
    // Let's rely on creating api/get_orders.php next.
    const tbody = document.getElementById('orderTableBody');
    if (!tbody) return;

    try {
        const response = await fetch(`${API_Base}/get_orders.php`);
        const orders = await response.json();
        tbody.innerHTML = orders.map(o => `
            <tr>
                <td>${o.id}</td>
                <td>${o.order_date}</td>
                <td>N/A Items</td> <!-- Joined query needed for count -->
                <td>$${parseFloat(o.total_amount).toFixed(2)}</td>
                <td><span class="badge ${o.status === 'Pending' ? 'bg-warning' : 'bg-success'}">${o.status}</span></td>
            </tr>
        `).join('');
    } catch (e) {
        console.log("Orders API not ready or error");
    }
}
