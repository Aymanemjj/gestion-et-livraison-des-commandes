<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livreur Dashboard - Delivery App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../config/styles.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navbar -->
    <nav id="navbar" class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i data-lucide="package" class="w-8 h-8 text-indigo-600"></i>
                    <span class="ml-2 text-xl font-bold text-indigo-600">DeliveryApp</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative" id="notification-bell">
                        <button id="notification-btn" class="relative p-2 text-gray-600 hover:text-indigo-600">
                            <i data-lucide="bell"></i>
                            <span id="notification-badge" class="hidden absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                        </button>
                        <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-3">Notifications</h3>
                                <div id="notification-list" class="space-y-2 max-h-96 overflow-y-auto">
                                    <p class="text-gray-500 text-sm">No notifications</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="user-name" class="text-gray-700 font-medium">Livreur</span>
                    <button id="logout-btn" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Tabs -->
        <div class="mb-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button id="tab-marketplace" class="tab-button active border-b-2 border-indigo-500 py-4 px-1 text-sm font-medium text-indigo-600">
                        Marketplace
                    </button>
                    <button id="tab-my-orders" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        My Deliveries
                    </button>
                </nav>
            </div>
        </div>

        <!-- Marketplace Tab -->
        <div id="marketplace-tab" class="tab-content">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Available Orders</h2>
                <p class="text-gray-600 mt-1">Browse and send offers for pending orders</p>
            </div>
            <div id="marketplace-orders" class="space-y-4">
                <!-- Orders will be dynamically inserted here -->
            </div>
            <div id="marketplace-empty" class="hidden text-center py-12">
                <i data-lucide="package-search" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No available orders</h3>
                <p class="text-gray-500">Check back later for new delivery requests</p>
            </div>
        </div>

        <!-- My Deliveries Tab -->
        <div id="my-orders-tab" class="tab-content hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">My Deliveries</h2>
                <p class="text-gray-600 mt-1">Manage your active and completed deliveries</p>
            </div>
            <div id="my-deliveries-list" class="space-y-4">
                <!-- Deliveries will be dynamically inserted here -->
            </div>
            <div id="deliveries-empty" class="hidden text-center py-12">
                <i data-lucide="truck" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No deliveries yet</h3>
                <p class="text-gray-500">Start by sending offers on available orders</p>
            </div>
        </div>
    </div>

    <!-- Send Offer Modal -->
    <div id="send-offer-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Send Offer</h3>
                <button id="close-offer-modal" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div id="offer-order-info" class="mb-4 p-3 bg-gray-50 rounded-md">
                <!-- Order info will be inserted here -->
            </div>
            <form id="send-offer-form" class="space-y-4">
                <div>
                    <label for="offer-price" class="block text-sm font-medium text-gray-700">Price (MAD)</label>
                    <input type="number" id="offer-price" step="0.01" min="0" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="offer-time" class="block text-sm font-medium text-gray-700">Estimated Delivery Time (hours)</label>
                    <input type="number" id="offer-time" min="1" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="offer-vehicle" class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                    <select id="offer-vehicle" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Select vehicle</option>
                        <option value="motorcycle">Motorcycle</option>
                        <option value="car">Car</option>
                        <option value="van">Van</option>
                        <option value="truck">Truck</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" id="offer-fragile" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Fragile items</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="offer-express" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Express delivery</span>
                    </label>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Send Offer
                    </button>
                    <button type="button" id="cancel-offer-modal" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Order Detail with Competitor Offers -->
    <div id="order-detail-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white my-10">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Order Details</h3>
                <button id="close-detail-modal" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div id="order-detail-content" class="space-y-6">
                <!-- Order info and competitor offers will be inserted here -->
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 text-sm">© 2024 DeliveryApp. All rights reserved.</p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Privacy</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Terms</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Notification Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <script src="config/main.js"></script>
    <script>
        lucide.createIcons();
        // Initialize livreur dashboard
        if (typeof initLivreurDashboard === 'function') {
            initLivreurDashboard();
        }
    </script>
</body>
</html>


