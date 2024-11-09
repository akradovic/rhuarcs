// ProductForm.js
import React, { useState, useEffect } from 'react';

const ProductForm = ({ product, onSubmit, onCancel }) => {
    const [formData, setFormData] = useState({
        title: '',
        description: '',
        price: '',
        stock: '',
        category: '',
        pet_type: '',
        ...product
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit(formData);
    };

    return (
        <div className="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center">
            <div className="bg-white rounded-lg p-8 max-w-2xl w-full mx-4">
                <h2 className="text-xl font-bold mb-6">
                    {product ? 'Edit Product' : 'Add New Product'}
                </h2>
                
                <form onSubmit={handleSubmit}>
                    <div className="space-y-4">
                        <div>
                            <label className="block text-sm font-medium mb-1">
                                Product Name
                            </label>
                            <input
                                type="text"
                                className="form-input"
                                value={formData.title}
                                onChange={(e) => setFormData({...formData, title: e.target.value})}
                                required
                            />
                        </div>
                        
                        <div>
                            <label className="block text-sm font-medium mb-1">
                                Description
                            </label>
                            <textarea
                                className="form-input"
                                value={formData.description}
                                onChange={(e) => setFormData({...formData, description: e.target.value})}
                                rows="4"
                            />
                        </div>
                        
                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium mb-1">
                                    Price
                                </label>
                                <input
                                    type="number"
                                    step="0.01"
                                    className="form-input"
                                    value={formData.price}
                                    onChange={(e) => setFormData({...formData, price: e.target.value})}
                                    required
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium mb-1">
                                    Stock
                                </label>
                                <input
                                    type="number"
                                    className="form-input"
                                    value={formData.stock}
                                    onChange={(e) => setFormData({...formData, stock: e.target.value})}
                                    required
                                />
                            </div>
                        </div>
                    </div>
                    
                    <div className="mt-8 flex justify-end space-x-4">
                        <button
                            type="button"
                            onClick={onCancel}
                            className="btn btn-secondary"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            className="btn btn-primary"
                        >
                            {product ? 'Update Product' : 'Add Product'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

// ProductRow.js
import React from 'react';
import { Pencil, Trash2 } from 'lucide-react';

const ProductRow = ({ product, onEdit, onDelete }) => {
    return (
        <tr className="hover:bg-gray-100">
            <td className="px-6 py-4">
                <div className="flex items-center">
                    {product.image && (
                        <img 
                            src={product.image} 
                            alt={product.title}
                            className="h-10 w-10 object-cover rounded-md mr-3"
                        />
                    )}
                    <div>
                        <div className="font-medium">{product.title}</div>
                        <div className="text-sm text-gray-600">{product.sku}</div>
                    </div>
                </div>
            </td>
            <td className="px-6 py-4">{product.category}</td>
            <td className="px-6 py-4">${parseFloat(product.price).toFixed(2)}</td>
            <td className="px-6 py-4">{product.stock}</td>
            <td className="px-6 py-4">
                <div className="flex space-x-4">
                    <button 
                        onClick={onEdit}
                        className="text-blue-600 hover:text-blue-800"
                    >
                        <Pencil size={18} />
                    </button>
                    <button 
                        onClick={onDelete}
                        className="text-red-600 hover:text-red-800"
                    >
                        <Trash2 size={18} />
                    </button>
                </div>
            </td>
        </tr>
    );
};

export default ProductRow;