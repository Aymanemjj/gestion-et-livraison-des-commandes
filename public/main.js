// ============================================
// STATE MANAGEMENT (localStorage Simulation)
// ============================================

const Storage = {
    get: (key) => {
        const item = localStorage.getItem(key);
        return item ? JSON.parse(item) : null;
    },
    set: (key, value) => {
        localStorage.setItem(key, JSON.stringify(value));
    },
    remove: (key) => {
        localStorage.removeItem(key);
    }
};

// Initialize default data if not exists
const initializeData = () => {
    if (!Storage.get('users')) {
        Storage.set('users', [
            { id: 1, name: 'Admin User', email: 'admin@delivery.com', password: 'admin123', role: 'admin', active: true },
            { id: 2, name: 'John Client', email: 'client@delivery.com', password: 'client123', role: 'client', active: true },
            { id: 3, name: 'Driver One', email: 'driver@delivery.com', password: 'driver123', role: 'livreur', active: true }
        ]);
    }
    if (!Storage.get('orders')) {
        Storage.set('orders', [
            {
                id: 1,
                title: 'Package Delivery',
                description: 'Deliver package from downtown to airport',
                pickup: '123 Main St, Downtown',
                delivery: 'Airport Terminal 1',
                status: 'pending',
                clientId: 2,
                createdAt: new Date().toISOString(),
                deleted: false
            }
        ]);
    }
    if (!Storage.get('offers')) {
        Storage.set('offers', []);
    }
    if (!Storage.get('notifications')) {
        Storage.set('notifications', []);
    }
    if (!Storage.get('currentUser')) {
        Storage.set('currentUser', null);
    }
};

initializeData();

// ============================================
// UTILITY FUNCTIONS
// ============================================

const showToast = (message, type = 'info') => {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) return;

    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500',
        warning: 'bg-yellow-500'
    };

    const toast = document.createElement('div');
    toast.className = `${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2 animate-slide-in`;
    toast.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    `;
    toastContainer.appendChild(toast);
    lucide.createIcons();

    setTimeout(() => {
        toast.classList.add('animate-slide-out');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
};

const getStatusBadge = (status) => {
    const badges = {
        created: '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Created</span>',
        pending: '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
        'in-treatment': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">In Treatment</span>',
        shipped: '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Shipped</span>',
        finished: '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Finished</span>',
        cancelled: '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>'
    };
    return badges[status] || badges.pending;
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
};

// ============================================
// AUTHENTICATION
// ============================================

const handleLogin = (e) => {
    e.preventDefault();
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    const users = Storage.get('users') || [];
    const user = users.find(u => u.email === email && u.password === password && u.active);

    if (user) {
        Storage.set('currentUser', user);
        showToast('Login successful!', 'success');
        setTimeout(() => {
            redirectToDashboard(user.role);
        }, 500);
    } else {
        showToast('Invalid email or password', 'error');
    }
};

const handleSignup = (e) => {
    e.preventDefault();
    const name = document.getElementById('signup-name').value;
    const email = document.getElementById('signup-email').value;
    const password = document.getElementById('signup-password').value;
    const role = document.getElementById('signup-role').value;

    const users = Storage.get('users') || [];
    if (users.find(u => u.email === email)) {
        showToast('Email already registered', 'error');
        return;
    }

    const newUser = {
        id: Date.now(),
        name,
        email,
        password,
        role,
        active: true
    };

    users.push(newUser);
    Storage.set('users', users);
    Storage.set('currentUser', newUser);
    showToast('Account created successfully!', 'success');
    setTimeout(() => {
        redirectToDashboard(role);
    }, 500);
};

const redirectToDashboard = (role) => {
    const dashboards = {
        client: 'dashboard-client.html',
        livreur: 'dashboard-livreur.html',
        admin: 'dashboard-admin.html'
    };
    window.location.href = dashboards[role] || 'index.html';
};

const handleLogout = () => {
    Storage.set('currentUser', null);
    window.location.href = 'index.html';
};

// ============================================
// CLIENT DASHBOARD
// ============================================

const initClientDashboard = () => {
    const currentUser = Storage.get('currentUser');
    if (!currentUser || currentUser.role !== 'client') {
        window.location.href = 'index.html';
        return;
    }

    document.getElementById('user-name').textContent = currentUser.name;
    document.getElementById('logout-btn').addEventListener('click', handleLogout);
    document.getElementById('create-order-btn').addEventListener('click', () => openCreateOrderModal());
    document.getElementById('create-order-empty-btn')?.addEventListener('click', () => openCreateOrderModal());
    document.getElementById('close-create-modal').addEventListener('click', closeCreateOrderModal);
    document.getElementById('cancel-create-modal').addEventListener('click', closeCreateOrderModal);
    document.getElementById('create-order-form').addEventListener('submit', handleCreateOrder);
    document.getElementById('close-detail-modal').addEventListener('click', closeOrderDetailModal);
    document.getElementById('close-edit-modal').addEventListener('click', closeEditOrderModal);
    document.getElementById('cancel-edit-modal').addEventListener('click', closeEditOrderModal);
    document.getElementById('edit-order-form').addEventListener('submit', handleEditOrder);
    document.getElementById('notification-btn')?.addEventListener('click', toggleNotifications);

    loadClientOrders();
    loadNotifications();
};

const loadClientOrders = () => {
    const currentUser = Storage.get('currentUser');
    const orders = Storage.get('orders') || [];
    const clientOrders = orders.filter(o => o.clientId === currentUser.id && !o.deleted);

    const container = document.getElementById('orders-container');
    const emptyState = document.getElementById('empty-state');

    if (clientOrders.length === 0) {
        container.classList.add('hidden');
        emptyState?.classList.remove('hidden');
        return;
    }

    container.classList.remove('hidden');
    emptyState?.classList.add('hidden');

    container.innerHTML = clientOrders.map(order => `
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">${order.title}</h3>
                    <p class="text-gray-600 mt-1">${order.description}</p>
                    <div class="mt-3 flex items-center space-x-4 text-sm text-gray-500">
                        <span><i data-lucide="map-pin" class="w-4 h-4 inline"></i> ${order.pickup} → ${order.delivery}</span>
                        <span><i data-lucide="calendar" class="w-4 h-4 inline"></i> ${formatDate(order.createdAt)}</span>
                    </div>
                </div>
                <div class="ml-4 flex flex-col items-end space-y-2">
                    ${getStatusBadge(order.status)}
                    <button onclick="viewOrderDetail(${order.id})" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        View Details
                    </button>
                    ${order.status === 'created' || order.status === 'pending' ? `
                        <div class="flex space-x-2">
                            <button onclick="openEditOrderModal(${order.id})" class="px-4 py-2 text-sm bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                                Edit
                            </button>
                            <button onclick="softDeleteOrder(${order.id})" class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Delete
                            </button>
                        </div>
                    ` : ''}
                </div>
            </div>
        </div>
    `).join('');

    lucide.createIcons();
};

const openCreateOrderModal = () => {
    document.getElementById('create-order-modal').classList.remove('hidden');
};

const closeCreateOrderModal = () => {
    document.getElementById('create-order-modal').classList.add('hidden');
    document.getElementById('create-order-form').reset();
};

const handleCreateOrder = (e) => {
    e.preventDefault();
    const currentUser = Storage.get('currentUser');
    const orders = Storage.get('orders') || [];

    const newOrder = {
        id: Date.now(),
        title: document.getElementById('order-title').value,
        description: document.getElementById('order-description').value,
        pickup: document.getElementById('order-pickup').value,
        delivery: document.getElementById('order-delivery').value,
        status: 'pending',
        clientId: currentUser.id,
        createdAt: new Date().toISOString(),
        deleted: false
    };

    orders.push(newOrder);
    Storage.set('orders', orders);
    showToast('Order created successfully!', 'success');
    closeCreateOrderModal();
    loadClientOrders();
};

const viewOrderDetail = (orderId) => {
    const orders = Storage.get('orders') || [];
    const offers = Storage.get('offers') || [];
    const users = Storage.get('users') || [];
    const order = orders.find(o => o.id === orderId);

    if (!order) return;

    const orderOffers = offers.filter(o => o.orderId === orderId);
    const orderOffersWithUsers = orderOffers.map(offer => ({
        ...offer,
        driver: users.find(u => u.id === offer.driverId)
    }));

    const modal = document.getElementById('order-detail-modal');
    const content = document.getElementById('order-detail-content');

    content.innerHTML = `
        <div class="bg-gray-50 p-4 rounded-md">
            <h4 class="font-semibold text-gray-900 mb-2">${order.title}</h4>
            <p class="text-gray-600 mb-3">${order.description}</p>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium">Pickup:</span> ${order.pickup}
                </div>
                <div>
                    <span class="font-medium">Delivery:</span> ${order.delivery}
                </div>
                <div>
                    <span class="font-medium">Status:</span> ${getStatusBadge(order.status)}
                </div>
                <div>
                    <span class="font-medium">Created:</span> ${formatDate(order.createdAt)}
                </div>
            </div>
        </div>
        <div>
            <h4 class="font-semibold text-gray-900 mb-3">Offers from Drivers</h4>
            ${orderOffersWithUsers.length === 0 ? 
                '<p class="text-gray-500">No offers yet</p>' :
                orderOffersWithUsers.map(offer => `
                    <div class="bg-white border border-gray-200 rounded-md p-4 mb-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-900">${offer.driver?.name || 'Unknown Driver'}</p>
                                <div class="mt-2 space-y-1 text-sm text-gray-600">
                                    <p><i data-lucide="truck" class="w-4 h-4 inline"></i> Vehicle: ${offer.vehicle}</p>
                                    <p><i data-lucide="clock" class="w-4 h-4 inline"></i> Estimated Time: ${offer.estimatedTime} hours</p>
                                    <p><i data-lucide="dollar-sign" class="w-4 h-4 inline"></i> Price: ${offer.price} MAD</p>
                                    ${offer.fragile ? '<span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Fragile</span>' : ''}
                                    ${offer.express ? '<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Express</span>' : ''}
                                </div>
                            </div>
                            ${order.status === 'pending' ? `
                                <button onclick="acceptOffer(${offer.id}, ${order.id})" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Accept Offer
                                </button>
                            ` : ''}
                        </div>
                    </div>
                `).join('')
            }
        </div>
    `;

    lucide.createIcons();
    modal.classList.remove('hidden');
};

const closeOrderDetailModal = () => {
    document.getElementById('order-detail-modal').classList.add('hidden');
};

const acceptOffer = (offerId, orderId) => {
    const orders = Storage.get('orders') || [];
    const offers = Storage.get('offers') || [];
    const notifications = Storage.get('notifications') || [];

    const order = orders.find(o => o.id === orderId);
    const offer = offers.find(o => o.id === offerId);

    if (order && offer) {
        order.status = 'in-treatment';
        order.driverId = offer.driverId;
        Storage.set('orders', orders);

        // Notify driver
        notifications.push({
            id: Date.now(),
            userId: offer.driverId,
            message: `Your offer for order "${order.title}" has been accepted!`,
            type: 'success',
            createdAt: new Date().toISOString()
        });
        Storage.set('notifications', notifications);

        showToast('Offer accepted! Order is now in treatment.', 'success');
        closeOrderDetailModal();
        loadClientOrders();
    }
};

const softDeleteOrder = (orderId) => {
    if (confirm('Are you sure you want to delete this order?')) {
        const orders = Storage.get('orders') || [];
        const order = orders.find(o => o.id === orderId);
        if (order) {
            order.deleted = true;
            Storage.set('orders', orders);
            showToast('Order deleted', 'success');
            loadClientOrders();
        }
    }
};

const openEditOrderModal = (orderId) => {
    const orders = Storage.get('orders') || [];
    const order = orders.find(o => o.id === orderId);
    if (!order) return;

    document.getElementById('edit-order-id').value = order.id;
    document.getElementById('edit-order-title').value = order.title;
    document.getElementById('edit-order-description').value = order.description;
    document.getElementById('edit-order-pickup').value = order.pickup;
    document.getElementById('edit-order-delivery').value = order.delivery;
    document.getElementById('edit-order-modal').classList.remove('hidden');
};

const closeEditOrderModal = () => {
    document.getElementById('edit-order-modal').classList.add('hidden');
    document.getElementById('edit-order-form').reset();
};

const handleEditOrder = (e) => {
    e.preventDefault();
    const orders = Storage.get('orders') || [];
    const orderId = parseInt(document.getElementById('edit-order-id').value);
    const order = orders.find(o => o.id === orderId);

    if (order && (order.status === 'created' || order.status === 'pending')) {
        order.title = document.getElementById('edit-order-title').value;
        order.description = document.getElementById('edit-order-description').value;
        order.pickup = document.getElementById('edit-order-pickup').value;
        order.delivery = document.getElementById('edit-order-delivery').value;
        Storage.set('orders', orders);
        showToast('Order updated successfully!', 'success');
        closeEditOrderModal();
        loadClientOrders();
    } else {
        showToast('Cannot edit order in current status', 'error');
    }
};

// ============================================
// LIVREUR DASHBOARD
// ============================================

const initLivreurDashboard = () => {
    const currentUser = Storage.get('currentUser');
    if (!currentUser || currentUser.role !== 'livreur') {
        window.location.href = 'index.html';
        return;
    }

    document.getElementById('user-name').textContent = currentUser.name;
    document.getElementById('logout-btn').addEventListener('click', handleLogout);
    document.getElementById('tab-marketplace').addEventListener('click', () => switchTab('marketplace'));
    document.getElementById('tab-my-orders').addEventListener('click', () => switchTab('my-orders'));
    document.getElementById('close-offer-modal').addEventListener('click', closeOfferModal);
    document.getElementById('cancel-offer-modal').addEventListener('click', closeOfferModal);
    document.getElementById('send-offer-form').addEventListener('submit', handleSendOffer);
    document.getElementById('close-detail-modal').addEventListener('click', closeOrderDetailModal);
    document.getElementById('notification-btn')?.addEventListener('click', toggleNotifications);

    loadMarketplace();
    loadMyDeliveries();
    loadNotifications();
};

const switchTab = (tab) => {
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));

    if (tab === 'marketplace') {
        document.getElementById('tab-marketplace').classList.add('active', 'border-indigo-500', 'text-indigo-600');
        document.getElementById('tab-marketplace').classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('marketplace-tab').classList.remove('hidden');
        loadMarketplace();
    } else {
        document.getElementById('tab-my-orders').classList.add('active', 'border-indigo-500', 'text-indigo-600');
        document.getElementById('tab-my-orders').classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('my-orders-tab').classList.remove('hidden');
        loadMyDeliveries();
    }
};

const loadMarketplace = () => {
    const orders = Storage.get('orders') || [];
    const offers = Storage.get('offers') || [];
    const currentUser = Storage.get('currentUser');
    const pendingOrders = orders.filter(o => o.status === 'pending' && !o.deleted);

    const container = document.getElementById('marketplace-orders');
    const emptyState = document.getElementById('marketplace-empty');

    if (pendingOrders.length === 0) {
        container.classList.add('hidden');
        emptyState?.classList.remove('hidden');
        return;
    }

    container.classList.remove('hidden');
    emptyState?.classList.add('hidden');

    container.innerHTML = pendingOrders.map(order => {
        const hasOffer = offers.some(o => o.orderId === order.id && o.driverId === currentUser.id);
        return `
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">${order.title}</h3>
                        <p class="text-gray-600 mt-1">${order.description}</p>
                        <div class="mt-3 flex items-center space-x-4 text-sm text-gray-500">
                            <span><i data-lucide="map-pin" class="w-4 h-4 inline"></i> ${order.pickup} → ${order.delivery}</span>
                            <span><i data-lucide="calendar" class="w-4 h-4 inline"></i> ${formatDate(order.createdAt)}</span>
                        </div>
                    </div>
                    <div class="ml-4 flex flex-col items-end space-y-2">
                        ${getStatusBadge(order.status)}
                        <button onclick="viewLivreurOrderDetail(${order.id})" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            View Details
                        </button>
                        ${!hasOffer ? `
                            <button onclick="openSendOfferModal(${order.id})" class="px-4 py-2 text-sm bg-green-600 text-white rounded-md hover:bg-green-700">
                                Send Offer
                            </button>
                        ` : `
                            <span class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-md">Offer Sent</span>
                        `}
                        <button onclick="viewOrderWithCompetitors(${order.id})" class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            View Competitors
                        </button>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    lucide.createIcons();
};

const openSendOfferModal = (orderId) => {
    const orders = Storage.get('orders') || [];
    const order = orders.find(o => o.id === orderId);
    if (!order) return;

    document.getElementById('send-offer-modal').setAttribute('data-order-id', orderId);
    document.getElementById('offer-order-info').innerHTML = `
        <h4 class="font-semibold text-gray-900">${order.title}</h4>
        <p class="text-sm text-gray-600 mt-1">${order.pickup} → ${order.delivery}</p>
    `;
    document.getElementById('send-offer-modal').classList.remove('hidden');
};

const closeOfferModal = () => {
    document.getElementById('send-offer-modal').classList.add('hidden');
    document.getElementById('send-offer-form').reset();
};

const handleSendOffer = (e) => {
    e.preventDefault();
    const currentUser = Storage.get('currentUser');
    const orderId = parseInt(document.getElementById('send-offer-modal').getAttribute('data-order-id'));
    const offers = Storage.get('offers') || [];
    const orders = Storage.get('orders') || [];
    const notifications = Storage.get('notifications') || [];

    const newOffer = {
        id: Date.now(),
        orderId: orderId,
        driverId: currentUser.id,
        price: parseFloat(document.getElementById('offer-price').value),
        estimatedTime: parseInt(document.getElementById('offer-time').value),
        vehicle: document.getElementById('offer-vehicle').value,
        fragile: document.getElementById('offer-fragile').checked,
        express: document.getElementById('offer-express').checked,
        createdAt: new Date().toISOString()
    };

    offers.push(newOffer);
    Storage.set('offers', offers);

    // Notify client
    const order = orders.find(o => o.id === orderId);
    if (order) {
        notifications.push({
            id: Date.now(),
            userId: order.clientId,
            message: `New offer received for order "${order.title}"`,
            type: 'info',
            createdAt: new Date().toISOString()
        });
        Storage.set('notifications', notifications);
    }

    showToast('Offer sent successfully!', 'success');
    closeOfferModal();
    loadMarketplace();
};

const viewOrderWithCompetitors = (orderId) => {
    const orders = Storage.get('orders') || [];
    const offers = Storage.get('offers') || [];
    const users = Storage.get('users') || [];
    const currentUser = Storage.get('currentUser');
    const order = orders.find(o => o.id === orderId);

    if (!order) return;

    const allOffers = offers.filter(o => o.orderId === orderId);
    const competitorOffers = allOffers.filter(o => o.driverId !== currentUser.id);
    const myOffer = allOffers.find(o => o.driverId === currentUser.id);

    const modal = document.getElementById('order-detail-modal');
    const content = document.getElementById('order-detail-content');

    content.innerHTML = `
        <div class="bg-gray-50 p-4 rounded-md">
            <h4 class="font-semibold text-gray-900 mb-2">${order.title}</h4>
            <p class="text-gray-600 mb-3">${order.description}</p>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="font-medium">Pickup:</span> ${order.pickup}</div>
                <div><span class="font-medium">Delivery:</span> ${order.delivery}</div>
            </div>
        </div>
        ${myOffer ? `
            <div class="bg-indigo-50 border-2 border-indigo-500 rounded-md p-4">
                <h4 class="font-semibold text-indigo-900 mb-2">Your Offer</h4>
                <div class="text-sm space-y-1">
                    <p><i data-lucide="dollar-sign" class="w-4 h-4 inline"></i> Price: ${myOffer.price} MAD</p>
                    <p><i data-lucide="clock" class="w-4 h-4 inline"></i> Time: ${myOffer.estimatedTime} hours</p>
                    <p><i data-lucide="truck" class="w-4 h-4 inline"></i> Vehicle: ${myOffer.vehicle}</p>
                </div>
            </div>
        ` : ''}
        <div>
            <h4 class="font-semibold text-gray-900 mb-3">Competitor Offers (Price Hidden)</h4>
            ${competitorOffers.length === 0 ? 
                '<p class="text-gray-500">No other offers yet</p>' :
                competitorOffers.map(offer => {
                    const driver = users.find(u => u.id === offer.driverId);
                    return `
                        <div class="bg-white border border-gray-200 rounded-md p-4 mb-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-900">${driver?.name || 'Unknown Driver'}</p>
                                    <div class="mt-2 space-y-1 text-sm text-gray-600">
                                        <p><i data-lucide="truck" class="w-4 h-4 inline"></i> Vehicle: ${offer.vehicle}</p>
                                        <p><i data-lucide="clock" class="w-4 h-4 inline"></i> Estimated Time: ${offer.estimatedTime} hours</p>
                                        <p><i data-lucide="dollar-sign" class="w-4 h-4 inline"></i> Price: <span class="text-gray-400">•••• MAD</span></p>
                                        ${offer.fragile ? '<span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Fragile</span>' : ''}
                                        ${offer.express ? '<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Express</span>' : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('')
            }
        </div>
    `;

    lucide.createIcons();
    modal.classList.remove('hidden');
};

const loadMyDeliveries = () => {
    const currentUser = Storage.get('currentUser');
    const orders = Storage.get('orders') || [];
    const myDeliveries = orders.filter(o => o.driverId === currentUser.id && (o.status === 'in-treatment' || o.status === 'shipped' || o.status === 'finished'));

    const container = document.getElementById('my-deliveries-list');
    const emptyState = document.getElementById('deliveries-empty');

    if (myDeliveries.length === 0) {
        container.classList.add('hidden');
        emptyState?.classList.remove('hidden');
        return;
    }

    container.classList.remove('hidden');
    emptyState?.classList.add('hidden');

    container.innerHTML = myDeliveries.map(order => `
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">${order.title}</h3>
                    <p class="text-gray-600 mt-1">${order.description}</p>
                    <div class="mt-3 flex items-center space-x-4 text-sm text-gray-500">
                        <span><i data-lucide="map-pin" class="w-4 h-4 inline"></i> ${order.pickup} → ${order.delivery}</span>
                    </div>
                </div>
                <div class="ml-4 flex flex-col items-end space-y-2">
                    ${getStatusBadge(order.status)}
                    <button onclick="viewLivreurOrderDetail(${order.id})" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        View Details
                    </button>
                    ${order.status === 'in-treatment' ? `
                        <button onclick="markAsShipped(${order.id})" class="px-4 py-2 text-sm bg-green-600 text-white rounded-md hover:bg-green-700">
                            Mark as Shipped
                        </button>
                    ` : ''}
                </div>
            </div>
        </div>
    `).join('');

    lucide.createIcons();
};

const viewLivreurOrderDetail = (orderId) => {
    const orders = Storage.get('orders') || [];
    const offers = Storage.get('offers') || [];
    const users = Storage.get('users') || [];
    const currentUser = Storage.get('currentUser');
    const order = orders.find(o => o.id === orderId);

    if (!order) return;

    const orderOffers = offers.filter(o => o.orderId === orderId);
    const orderOffersWithUsers = orderOffers.map(offer => ({
        ...offer,
        driver: users.find(u => u.id === offer.driverId)
    }));

    const modal = document.getElementById('order-detail-modal');
    const content = document.getElementById('order-detail-content');

    content.innerHTML = `
        <div class="bg-gray-50 p-4 rounded-md">
            <h4 class="font-semibold text-gray-900 mb-2">${order.title}</h4>
            <p class="text-gray-600 mb-3">${order.description}</p>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium">Pickup:</span> ${order.pickup}
                </div>
                <div>
                    <span class="font-medium">Delivery:</span> ${order.delivery}
                </div>
                <div>
                    <span class="font-medium">Status:</span> ${getStatusBadge(order.status)}
                </div>
                <div>
                    <span class="font-medium">Created:</span> ${formatDate(order.createdAt)}
                </div>
            </div>
        </div>
        <div>
            <h4 class="font-semibold text-gray-900 mb-3">All Offers</h4>
            ${orderOffersWithUsers.length === 0 ? 
                '<p class="text-gray-500">No offers yet</p>' :
                orderOffersWithUsers.map(offer => {
                    const isMyOffer = offer.driverId === currentUser.id;
                    return `
                        <div class="bg-white border ${isMyOffer ? 'border-indigo-500 border-2' : 'border-gray-200'} rounded-md p-4 mb-3 ${isMyOffer ? 'bg-indigo-50' : ''}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-900">${offer.driver?.name || 'Unknown Driver'} ${isMyOffer ? '<span class="text-xs text-indigo-600">(Your Offer)</span>' : ''}</p>
                                    <div class="mt-2 space-y-1 text-sm text-gray-600">
                                        <p><i data-lucide="truck" class="w-4 h-4 inline"></i> Vehicle: ${offer.vehicle}</p>
                                        <p><i data-lucide="clock" class="w-4 h-4 inline"></i> Estimated Time: ${offer.estimatedTime} hours</p>
                                        <p><i data-lucide="dollar-sign" class="w-4 h-4 inline"></i> Price: ${isMyOffer ? `${offer.price} MAD` : '<span class="text-gray-400">•••• MAD</span>'}</p>
                                        ${offer.fragile ? '<span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Fragile</span>' : ''}
                                        ${offer.express ? '<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Express</span>' : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('')
            }
        </div>
    `;

    lucide.createIcons();
    modal.classList.remove('hidden');
};

const markAsShipped = (orderId) => {
    const orders = Storage.get('orders') || [];
    const notifications = Storage.get('notifications') || [];
    const order = orders.find(o => o.id === orderId);

    if (order) {
        order.status = 'shipped';
        Storage.set('orders', orders);

        // Notify client
        notifications.push({
            id: Date.now(),
            userId: order.clientId,
            message: `Your order "${order.title}" has been shipped!`,
            type: 'success',
            createdAt: new Date().toISOString()
        });
        Storage.set('notifications', notifications);

        showToast('Order marked as shipped!', 'success');
        loadMyDeliveries();
    }
};

// ============================================
// ADMIN DASHBOARD
// ============================================

const initAdminDashboard = () => {
    const currentUser = Storage.get('currentUser');
    if (!currentUser || currentUser.role !== 'admin') {
        window.location.href = 'index.html';
        return;
    }

    document.getElementById('user-name').textContent = currentUser.name;
    document.getElementById('logout-btn').addEventListener('click', handleLogout);
    document.getElementById('close-edit-user-modal').addEventListener('click', closeEditUserModal);
    document.getElementById('cancel-edit-user-modal').addEventListener('click', closeEditUserModal);
    document.getElementById('edit-user-form').addEventListener('submit', handleEditUser);

    loadStatistics();
    loadUsers();
};

const loadStatistics = () => {
    const orders = Storage.get('orders') || [];
    const users = Storage.get('users') || [];

    const totalOrders = orders.filter(o => !o.deleted).length;
    const finishedOrders = orders.filter(o => o.status === 'finished' && !o.deleted).length;
    const cancelledOrders = orders.filter(o => o.status === 'cancelled' && !o.deleted).length;
    const activeDrivers = users.filter(u => u.role === 'livreur' && u.active).length;

    document.getElementById('stat-total-orders').textContent = totalOrders;
    document.getElementById('stat-finished-orders').textContent = finishedOrders;
    document.getElementById('stat-cancelled-orders').textContent = cancelledOrders;
    document.getElementById('stat-active-drivers').textContent = activeDrivers;
};

const loadUsers = () => {
    const users = Storage.get('users') || [];
    const container = document.getElementById('users-table-body');
    const emptyState = document.getElementById('users-empty');

    if (users.length === 0) {
        container.classList.add('hidden');
        emptyState?.classList.remove('hidden');
        return;
    }

    container.classList.remove('hidden');
    emptyState?.classList.add('hidden');

    container.innerHTML = users.map(user => `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${user.name}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.email}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">${user.role}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" ${user.active ? 'checked' : ''} 
                        onchange="toggleUserStatus(${user.id})" 
                        class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="ml-3 text-sm text-gray-700">${user.active ? 'Active' : 'Inactive'}</span>
                </label>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button onclick="openEditUserModal(${user.id})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
            </td>
        </tr>
    `).join('');
};

const toggleUserStatus = (userId) => {
    const users = Storage.get('users') || [];
    const user = users.find(u => u.id === userId);
    if (user) {
        user.active = !user.active;
        Storage.set('users', users);
        loadUsers();
        loadStatistics();
        showToast(`User ${user.active ? 'activated' : 'deactivated'}`, 'success');
    }
};

const openEditUserModal = (userId) => {
    const users = Storage.get('users') || [];
    const user = users.find(u => u.id === userId);
    if (!user) return;

    document.getElementById('edit-user-id').value = user.id;
    document.getElementById('edit-user-name').value = user.name;
    document.getElementById('edit-user-email').value = user.email;
    document.getElementById('edit-user-role').value = user.role;
    document.getElementById('edit-user-modal').classList.remove('hidden');
};

const closeEditUserModal = () => {
    document.getElementById('edit-user-modal').classList.add('hidden');
    document.getElementById('edit-user-form').reset();
};

const handleEditUser = (e) => {
    e.preventDefault();
    const users = Storage.get('users') || [];
    const userId = parseInt(document.getElementById('edit-user-id').value);
    const user = users.find(u => u.id === userId);

    if (user) {
        user.name = document.getElementById('edit-user-name').value;
        user.email = document.getElementById('edit-user-email').value;
        user.role = document.getElementById('edit-user-role').value;
        Storage.set('users', users);
        showToast('User updated successfully!', 'success');
        closeEditUserModal();
        loadUsers();
        loadStatistics();
    }
};

// ============================================
// NOTIFICATIONS
// ============================================

const loadNotifications = () => {
    const currentUser = Storage.get('currentUser');
    if (!currentUser) return;

    const notifications = Storage.get('notifications') || [];
    const userNotifications = notifications.filter(n => n.userId === currentUser.id).slice(-10).reverse();

    const badge = document.getElementById('notification-badge');
    const list = document.getElementById('notification-list');

    if (badge) {
        if (userNotifications.length > 0) {
            badge.textContent = userNotifications.length;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    if (list) {
        if (userNotifications.length === 0) {
            list.innerHTML = '<p class="text-gray-500 text-sm">No notifications</p>';
        } else {
            list.innerHTML = userNotifications.map(notif => `
                <div class="p-3 bg-gray-50 rounded-md hover:bg-gray-100 cursor-pointer">
                    <p class="text-sm text-gray-900">${notif.message}</p>
                    <p class="text-xs text-gray-500 mt-1">${formatDate(notif.createdAt)}</p>
                </div>
            `).join('');
        }
    }
};

const toggleNotifications = () => {
    const dropdown = document.getElementById('notification-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
        loadNotifications();
    }
};

// ============================================
// INITIALIZE ON PAGE LOAD
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    // Check if user is logged in
    const currentUser = Storage.get('currentUser');
    const currentPage = window.location.pathname;

    // If on index.html and logged in, redirect to dashboard
    if (currentPage.includes('index.html') && currentUser) {
        redirectToDashboard(currentUser.role);
        return;
    }

    // If on dashboard and not logged in, redirect to login
    if (currentPage.includes('dashboard') && !currentUser) {
        window.location.href = 'index.html';
        return;
    }

    // Initialize auth forms
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const showSignup = document.getElementById('show-signup');
    const showLogin = document.getElementById('show-login');

    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }
    if (signupForm) {
        signupForm.addEventListener('submit', handleSignup);
    }
    if (showSignup) {
        showSignup.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('signup-form').classList.remove('hidden');
        });
    }
    if (showLogin) {
        showLogin.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('signup-form').classList.add('hidden');
            document.getElementById('login-form').classList.remove('hidden');
        });
    }
});

// Make functions globally available
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


