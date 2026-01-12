<?php

use App\models\Auth;
use App\models\Command;
use App\models\User;

require '../../vendor/autoload.php';

session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    switch ($_POST['submit']) {
        case 'logout':

            $auth = new Auth();
            $auth->logOut();
            break;

        case 'command':
            $command = new Command();
            $command->afterMath();
            break;
            
    }
}


?>










<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - Delivery App</title>
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
                            <span id="notification-badge"
                                class="hidden absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                        </button>
                        <div id="notification-dropdown"
                            class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-3">Notifications</h3>
                                <div id="notification-list" class="space-y-2 max-h-96 overflow-y-auto">
                                    <p class="text-gray-500 text-sm">No notifications</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="user-name" class="text-gray-700 font-medium"><?php echo $_SESSION['fullname']; ?></span>
                    <form method="post">
                        <button type="submit" name="submit" value="logout" id="logout-btn"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                <button id="create-order-btn"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex items-center space-x-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Create Order</span>
                </button>
            </div>
        </div>
        <?php
        $command = new Command();
        $list = $command->find();
        if (empty($list)) {
            echo '<!-- Empty State -->
            <div id="empty-state" class="text-center py-12">
                <i data-lucide="package-x" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-500 mb-4">Create your first delivery order to get started</p>
                <button id="create-order-empty-btn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Create Order
                </button>
        </div>';
        } else {

            echo '<div id="orders-container" class="space-y-4">';

            foreach ($list as $order) {
                echo '
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">' . $order->getTitle() . '</h3>
                    <p class="text-gray-600 mt-1">' . $order->getDetails() . '</p>
                    <div class="mt-3 flex items-center space-x-4 text-sm text-gray-500">
                        <span><i data-lucide="map-pin" class="w-4 h-4 inline"></i>' . $order->getAddress() . '</span>
                        <span><i data-lucide="calendar" class="w-4 h-4 inline"></i>' . $order->getCreated_date() . '</span>
                    </div>
                </div>
                <div class="ml-4 flex flex-col items-end space-y-2">
                    ' . $order->status() . ' 


                    <form method="post" action="">
                        <button type="submit" name="viewDetails" value=" ' . $order->getId() . '"   class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            View Details
                        </button>
                            <div class="flex space-x-2">
                                <button type="submit" name="edit" value=" ' . $order->getId() . '" class="px-4 py-2 text-sm bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                                    Edit
                                </button>
                                <button type="submit" name="delete" value=" ' . $order->getId() . '" class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                    Delete
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>';
            }

            echo '</div>'; 
        }


        ?>




        <!-- Create Order Modal -->
        <div id="create-order-modal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Create New Order</h3>
                    <button id="close-create-modal" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <form id="create-order-form" class="space-y-4" method="post" action="">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="order-title" name="title" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="details" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="order-description" name="details" rows="3" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Delivery Address</label>
                        <input type="text" id="order-delivery" name="address" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" name="submit" value="command"
                            class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Create Order
                        </button>
                        <button type="button" id="cancel-create-modal"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Order Modal -->
        <div id="edit-order-modal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Edit Order</h3>
                    <button id="close-edit-modal" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <form id="edit-order-form" class="space-y-4" method="post" action="">
                    <input type="hidden" id="edit-order-id">
                    <div>
                        <label for="edit-order-title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="edit-order-title" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="edit-order-description"
                            class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="edit-order-description" rows="3" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>
                    <div>
                        <label for="edit-order-pickup" class="block text-sm font-medium text-gray-700">Pickup
                            Address</label>
                        <input type="text" id="edit-order-pickup" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="edit-order-delivery" class="block text-sm font-medium text-gray-700">Delivery
                            Address</label>
                        <input type="text" id="edit-order-delivery" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Save Changes
                        </button>
                        <button type="button" id="cancel-edit-modal"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Detail Modal -->
        <div id="order-detail-modal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-10 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white my-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Order Details</h3>
                    <button id="close-detail-modal" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <div id="order-detail-content" class="space-y-6">
                    <!-- Order info and offers will be inserted here -->
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

        <script src="../config/main.js"></script>
        <script>
            lucide.createIcons();
            // Initialize client dashboard
            if (typeof initClientDashboard === 'function') {
                initClientDashboard();
            }
        </script>
</body>

</html>