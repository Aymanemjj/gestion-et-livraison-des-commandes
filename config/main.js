// ============================================
// NO VALIDATION - Just redirect to dashboards
// ============================================
// 
// Login: Enter anything, goes to client dashboard
// Signup: Enter anything, goes to dashboard based on role you select
// No validation, no storage, just redirects!
// ============================================

// Handle login form - no validation, just redirect
function handleLogin(event) {
    event.preventDefault();
    
    // Just redirect to client dashboard - no checking anything!
    window.location.href = '../views/dashboard-client.php';
}

// Handle signup form - no validation, just redirect based on role
function handleSignup(event) {
    event.preventDefault();
    
    // Get the role they selected
    const role = document.getElementById('signup-role').value;
    
    // If no role selected, default to client
    if (!role || role === '') {
        window.location.href = '../views/dashboard-client.php';
        return; 
    }
    
    // Redirect based on role
    if (role === 'client') {
        window.location.href = '../views/dashboard-client.php';
    } else if (role === 'livreur') {
        window.location.href = '../views/dashboard-livreur.php';
    } else if (role === 'admin') {
        window.location.href = '../views/dashboard-admin.php';
    } else {
        // Default to client
        window.location.href = '../views/dashboard-client.php';
    }
}

// Logout function - just go back to login page
function handleLogout() {
    window.location.href = '../public/index.php';
}

// ============================================
// UI HELPER FUNCTIONS
// ============================================

// Show a message/toast notification
function showMessage(message, type) {
    const container = document.getElementById('toast-container');
    if (!container) return;
    
    // Colors for different message types
    let color = 'bg-blue-500';
    if (type === 'success') color = 'bg-green-500';
    if (type === 'error') color = 'bg-red-500';
    if (type === 'warning') color = 'bg-yellow-500';
    
    // Create message element
    const messageDiv = document.createElement('div');
    messageDiv.className = color + ' text-white px-6 py-3 rounded-lg shadow-lg';
    messageDiv.textContent = message;
    
    // Add to page
    container.appendChild(messageDiv);
    
    // Remove after 3 seconds
    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}

// Get status badge HTML (for showing order status)
function getStatusBadge(status) {
    const badges = {
        created: '<span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">Created</span>',
        pending: '<span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Pending</span>',
        'in-treatment': '<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">In Treatment</span>',
        shipped: '<span class="px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded">Shipped</span>',
        finished: '<span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Finished</span>',
        cancelled: '<span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Cancelled</span>'
    };
    return badges[status] || badges.pending;
}

// Format date nicely
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

// ============================================
// MODAL FUNCTIONS (Open/Close popups)
// ============================================

// Open create order modal
function openCreateOrderModal() {
    const modal = document.getElementById('create-order-modal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

// Close create order modal
function closeCreateOrderModal() {
    const modal = document.getElementById('create-order-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
    // Reset form
    const form = document.getElementById('create-order-form');
    if (form) {
        form.reset();
    }
}

// Open edit order modal
function openEditOrderModal(orderId) {
    const modal = document.getElementById('edit-order-modal');
    if (modal) {
        modal.classList.remove('hidden');
    }
    // PHP will populate the form fields
}

// Close edit order modal
function closeEditOrderModal() {
    const modal = document.getElementById('edit-order-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
    // Reset form
    const form = document.getElementById('edit-order-form');
    if (form) {
        form.reset();
    }
}

// Open order detail modal
function viewOrderDetail(orderId) {
    const modal = document.getElementById('order-detail-modal');
    if (modal) {
        modal.classList.remove('hidden');
    }
    // PHP will populate the content
}

// Close order detail modal
function closeOrderDetailModal() {
    const modal = document.getElementById('order-detail-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Open send offer modal (for livreur)
function openSendOfferModal(orderId) {
    const modal = document.getElementById('send-offer-modal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.setAttribute('data-order-id', orderId);
    }
}

// Close send offer modal
function closeOfferModal() {
    const modal = document.getElementById('send-offer-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
    // Reset form
    const form = document.getElementById('send-offer-form');
    if (form) {
        form.reset();
    }
}

// ============================================
// TAB SWITCHING (for livreur dashboard)
// ============================================

function switchTab(tabName) {
    // Remove active class from all tabs
    const allTabs = document.querySelectorAll('.tab-button');
    allTabs.forEach(tab => {
        tab.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Hide all tab content
    const allContent = document.querySelectorAll('.tab-content');
    allContent.forEach(content => {
        content.classList.add('hidden');
    });
    
    // Show selected tab
    if (tabName === 'marketplace') {
        const tab = document.getElementById('tab-marketplace');
        const content = document.getElementById('marketplace-tab');
        if (tab) {
            tab.classList.add('active', 'border-indigo-500', 'text-indigo-600');
            tab.classList.remove('border-transparent', 'text-gray-500');
        }
        if (content) {
            content.classList.remove('hidden');
        }
    } else if (tabName === 'my-orders') {
        const tab = document.getElementById('tab-my-orders');
        const content = document.getElementById('my-orders-tab');
        if (tab) {
            tab.classList.add('active', 'border-indigo-500', 'text-indigo-600');
            tab.classList.remove('border-transparent', 'text-gray-500');
        }
        if (content) {
            content.classList.remove('hidden');
        }
    }
}

// ============================================
// DASHBOARD INITIALIZATION
// ============================================

// Initialize client dashboard
function initClientDashboard() {
    // Set up logout button
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', handleLogout);
    }
    
    // Set up create order button
    const createBtn = document.getElementById('create-order-btn');
    if (createBtn) {
        createBtn.addEventListener('click', openCreateOrderModal);
    }
    
    const createBtnEmpty = document.getElementById('create-order-empty-btn');
    if (createBtnEmpty) {
        createBtnEmpty.addEventListener('click', openCreateOrderModal);
    }
    
    // Set up modal close buttons
    const closeCreateBtn = document.getElementById('close-create-modal');
    if (closeCreateBtn) {
        closeCreateBtn.addEventListener('click', closeCreateOrderModal);
    }
    
    const cancelCreateBtn = document.getElementById('cancel-create-modal');
    if (cancelCreateBtn) {
        cancelCreateBtn.addEventListener('click', closeCreateOrderModal);
    }
    
    const closeDetailBtn = document.getElementById('close-detail-modal');
    if (closeDetailBtn) {
        closeDetailBtn.addEventListener('click', closeOrderDetailModal);
    }
    
    const closeEditBtn = document.getElementById('close-edit-modal');
    if (closeEditBtn) {
        closeEditBtn.addEventListener('click', closeEditOrderModal);
    }
    
    const cancelEditBtn = document.getElementById('cancel-edit-modal');
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', closeEditOrderModal);
    }
}

// Initialize livreur dashboard
function initLivreurDashboard() {
    // Set up logout button
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', handleLogout);
    }
    
    // Set up tabs
    const marketplaceTab = document.getElementById('tab-marketplace');
    if (marketplaceTab) {
        marketplaceTab.addEventListener('click', () => switchTab('marketplace'));
    }
    
    const myOrdersTab = document.getElementById('tab-my-orders');
    if (myOrdersTab) {
        myOrdersTab.addEventListener('click', () => switchTab('my-orders'));
    }
    
    // Set up modal buttons
    const closeOfferBtn = document.getElementById('close-offer-modal');
    if (closeOfferBtn) {
        closeOfferBtn.addEventListener('click', closeOfferModal);
    }
    
    const cancelOfferBtn = document.getElementById('cancel-offer-modal');
    if (cancelOfferBtn) {
        cancelOfferBtn.addEventListener('click', closeOfferModal);
    }
    
    const closeDetailBtn = document.getElementById('close-detail-modal');
    if (closeDetailBtn) {
        closeDetailBtn.addEventListener('click', closeOrderDetailModal);
    }
}

// Initialize admin dashboard
function initAdminDashboard() {
    // Set up logout button
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', handleLogout);
    }
    
    // Set up modal buttons
    const closeEditUserBtn = document.getElementById('close-edit-user-modal');
    if (closeEditUserBtn) {
        closeEditUserBtn.addEventListener('click', closeEditUserModal);
    }
    
    const cancelEditUserBtn = document.getElementById('cancel-edit-user-modal');
    if (cancelEditUserBtn) {
        cancelEditUserBtn.addEventListener('click', closeEditUserModal);
    }
}

// Close edit user modal
function closeEditUserModal() {
    const modal = document.getElementById('edit-user-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
    const form = document.getElementById('edit-user-form');
    if (form) {
        form.reset();
    }
}

// Open edit user modal
function openEditUserModal(userId) {
    const modal = document.getElementById('edit-user-modal');
    if (modal) {
        modal.classList.remove('hidden');
    }
    // PHP will populate the form
}

// ============================================
// PLACEHOLDER FUNCTIONS (for buttons that need PHP)
// ============================================

function acceptOffer(offerId, orderId) {
    showMessage('This will be handled by PHP', 'info');
}

function softDeleteOrder(orderId) {
    if (confirm('Delete this order?')) {
        showMessage('This will be handled by PHP', 'info');
    }
}

function viewLivreurOrderDetail(orderId) {
    viewOrderDetail(orderId);
}

function viewOrderWithCompetitors(orderId) {
    viewOrderDetail(orderId);
}

function markAsShipped(orderId) {
    if (confirm('Mark as shipped?')) {
        showMessage('This will be handled by PHP', 'info');
    }
}

function toggleUserStatus(userId) {
    showMessage('This will be handled by PHP', 'info');
}

function toggleNotifications() {
    const dropdown = document.getElementById('notification-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}

// ============================================
// START WHEN PAGE LOADS
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // Set up login form
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }
    
    // Set up signup form
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        signupForm.addEventListener('submit', handleSignup);
    }
    
    // Switch between login and signup forms
    const showSignupLink = document.getElementById('show-signup');
    if (showSignupLink) {
        showSignupLink.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('signup-form').classList.remove('hidden');
        });
    }
    
    const showLoginLink = document.getElementById('show-login');
    if (showLoginLink) {
        showLoginLink.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('signup-form').classList.add('hidden');
            document.getElementById('login-form').classList.remove('hidden');
        });
    }
    
    // Initialize icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

// Make functions available globally (for onclick attributes in HTML)
window.viewOrderDetail = viewOrderDetail;
window.acceptOffer = acceptOffer;
window.softDeleteOrder = softDeleteOrder;
window.openEditOrderModal = openEditOrderModal;
window.openSendOfferModal = openSendOfferModal;
window.viewOrderWithCompetitors = viewOrderWithCompetitors;
window.viewLivreurOrderDetail = viewLivreurOrderDetail;
window.markAsShipped = markAsShipped;
window.toggleUserStatus = toggleUserStatus;
window.openEditUserModal = openEditUserModal;
