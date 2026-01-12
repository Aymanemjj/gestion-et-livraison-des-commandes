<?php

use App\models\Administration;
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
    <title>Admin Dashboard - Delivery App</title>
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
        <!-- Statistics Dashboard -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Orders Card -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Orders</p>
                            <?php
                            $admin = new Administration();
                            $count = $admin->countTotalCommands();

                            echo '<p id="stat-total-orders" class="text-2xl font-bold text-gray-900 mt-2">' . $count . '</p>';
                            ?>

                        </div>
                        <div class="bg-indigo-100 rounded-full p-3">
                            <i data-lucide="package" class="w-6 h-6 text-indigo-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Finished Orders Card -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Finished Orders</p>
                            <p id="stat-finished-orders" class="text-2xl font-bold text-gray-900 mt-2">0</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders Card -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                            <?php
                            $admin = new Administration();
                            $count = $admin->countPendingCommands();

                            echo '<p id="stat-total-orders" class="text-2xl font-bold text-gray-900 mt-2">' . $count . '</p>';
                            ?>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <i data-lucide="x-circle" class="w-6 h-6 text-yellow-800"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Drivers Card -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Active Drivers</p>
                            <?php
                            $admin = new Administration();
                            $count = $admin->countActiveDrivers();

                            echo '<p id="stat-total-orders" class="text-2xl font-bold text-gray-900 mt-2">' . $count . '</p>';
                            ?>                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <i data-lucide="truck" class="w-6 h-6 text-blue-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Management -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">User Management</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Users will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>
            <div id="users-empty" class="hidden text-center py-12">
                <i data-lucide="users" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                <p class="text-gray-500">Users will appear here once they register</p>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="edit-user-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Edit User</h3>
                <button id="close-edit-user-modal" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form id="edit-user-form" class="space-y-4">
                <input type="hidden" id="edit-user-id">
                <div>
                    <label for="edit-user-name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="edit-user-name" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="edit-user-email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="edit-user-email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="edit-user-role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select id="edit-user-role" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="client">Client</option>
                        <option value="livreur">Livreur</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Save Changes
                    </button>
                    <button type="button" id="cancel-edit-user-modal" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                </div>
            </form>
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
        // Initialize admin dashboard
        if (typeof initAdminDashboard === 'function') {
            initAdminDashboard();
        }
    </script>
</body>

</html>