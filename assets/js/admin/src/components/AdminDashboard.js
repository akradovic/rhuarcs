import React, { useState } from 'react';
import { Package, PlusCircle, Search } from 'lucide-react';
import ProductForm from './ProductForm';
import ProductRow from './ProductRow';
import { useProducts } from '../hooks/useProducts';

const AdminDashboard = () => {
  const [showProductForm, setShowProductForm] = useState(false);
  const [selectedProduct, setSelectedProduct] = useState(null);
  const [searchQuery, setSearchQuery] = useState('');
  const { products, loading, refreshProducts } = useProducts();

  const handleEdit = (product) => {
    setSelectedProduct(product);
    setShowProductForm(true);
  };

  const handleDelete = async (productId) => {
    if (!confirm('Are you sure you want to delete this product?')) return;
    
    try {
      const response = await fetch(`${rhuarcsAdmin.ajaxUrl}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
          action: 'rhuarcs_delete_product',
          nonce: rhuarcsAdmin.nonce,
          product_id: productId
        })
      });
      
      const data = await response.json();
      if (data.success) {
        refreshProducts();
      }
    } catch (error) {
      console.error('Error deleting product:', error);
    }
  };

  const filteredProducts = products.filter(product => 
    product.title.toLowerCase().includes(searchQuery.toLowerCase())
  );

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <header className="bg-white border-b">
        <div className="container mx-auto px-4">
          <div className="flex items-center justify-between h-16">
            <div className="font-bold text-xl text-brand-purple">Products Management</div>
          </div>
        </div>
      </header>

      <div className="container mx-auto px-4 py-6">
        {/* Action Bar */}
        <div className="bg-white rounded-lg shadow-sm p-4 mb-6">
          <div className="flex justify-between items-center">
            <div className="relative">
              <input
                type="text"
                placeholder="Search products..."
                className="pl-10 pr-4 py-2 border rounded-md w-64"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
              />
              <Search className="absolute left-3 top-2.5 text-gray-400" size={20} />
            </div>
            
            <button 
              onClick={() => {
                setSelectedProduct(null);
                setShowProductForm(true);
              }}
              className="btn btn-primary flex items-center gap-2"
            >
              <PlusCircle size={20} />
              Add Product
            </button>
          </div>
        </div>

        {/* Products Table */}
        <div className="bg-white rounded-lg shadow-sm overflow-hidden">
          {loading ? (
            <div className="p-8 text-center">Loading...</div>
          ) : (
            <table className="w-full">
              <thead className="bg-gray-50">
                <tr>
                  <th className="px-4 py-3 text-left text-sm font-medium text-gray-600">Product</th>
                  <th className="px-4 py-3 text-left text-sm font-medium text-gray-600">Category</th>
                  <th className="px-4 py-3 text-left text-sm font-medium text-gray-600">Price</th>
                  <th className="px-4 py-3 text-left text-sm font-medium text-gray-600">Stock</th>
                  <th className="px-4 py-3 text-left text-sm font-medium text-gray-600">Actions</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-200">
                {filteredProducts.map(product => (
                  <ProductRow 
                    key={product.id}
                    product={product}
                    onEdit={() => handleEdit(product)}
                    onDelete={() => handleDelete(product.id)}
                  />
                ))}
              </tbody>
            </table>
          )}
        </div>
      </div>

      {/* Product Form Modal */}
      {showProductForm && (
        <ProductForm
          product={selectedProduct}
          onSubmit={async (formData) => {
            // Handle form submission
            try {
              const response = await fetch(`${rhuarcsAdmin.ajaxUrl}`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                  action: selectedProduct ? 'rhuarcs_update_product' : 'rhuarcs_add_product',
                  nonce: rhuarcsAdmin.nonce,
                  ...formData
                })
              });
              
              const data = await response.json();
              if (data.success) {
                refreshProducts();
                setShowProductForm(false);
              }
            } catch (error) {
              console.error('Error saving product:', error);
            }
          }}
          onCancel={() => setShowProductForm(false)}
        />
      )}
    </div>
  );
};

export default AdminDashboard;