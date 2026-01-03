// js/data.js

const API_Base = 'api'; // Relative path

// We no longer keep a static array here. 
// Instead, we expose functions to fetch data.

async function fetchProducts() {
    try {
        const response = await fetch(`${API_Base}/products.php`);
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching products:', error);
        // Fallback for demo purposes if PHP is not running
        return [];
    }
}

async function fetchProductById(id) {
    try {
        const response = await fetch(`${API_Base}/products.php?id=${id}`);
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        return data; // Returns object or null
    } catch (error) {
        console.error('Error fetching product:', error);
        return null;
    }
}
