// assets/js/admin/src/hooks/useProducts.js
import { useState, useEffect } from 'react';

export function useProducts() {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);

    const fetchProducts = async () => {
        try {
            const response = await fetch(`${rhuarcsAdmin.ajaxUrl}?action=rhuarcs_get_products&nonce=${rhuarcsAdmin.nonce}`);
            const data = await response.json();
            if (data.success) {
                setProducts(data.data);
            }
        } catch (error) {
            console.error('Error fetching products:', error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchProducts();
    }, []);

    return { products, loading, refreshProducts: fetchProducts };
}