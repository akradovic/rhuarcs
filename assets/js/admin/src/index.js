// assets/js/admin/src/index.js
import React from 'react';
import { createRoot } from 'react-dom/client';
import AdminDashboard from './components/AdminDashboard';

// Initialize our admin panel
document.addEventListener('DOMContentLoaded', () => {
    const adminContainer = document.getElementById('rhuarcs-admin');
    if (adminContainer) {
        const root = createRoot(adminContainer);
        root.render(<AdminDashboard />);
    }
});