<?php
require '../vendor/autoload.php';

use App\models\BaseModelUser;
use App\models\BaseModelCommand;
use App\models\BaseModelOffer;
use App\models\User;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}




















?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery App - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../config/styles.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gradient-to-br from-indigo-50 to-slate-100 min-h-screen">
    <!-- Navbar -->
    <nav id="navbar" class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i data-lucide="package" class="w-8 h-8 text-indigo-600"></i>
                    <span class="ml-2 text-xl font-bold text-indigo-600">DeliveryApp</span>
                </div>
                <div class="hidden md:flex space-x-4">
                    <a href="index.html" class="text-indigo-600 hover:text-indigo-800 font-medium">Home</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex items-center justify-center min-h-[calc(100vh-4rem)] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Auth Container -->
            <div id="auth-container" class="bg-white rounded-lg shadow-xl p-8">
                <!-- Login Form -->
                <div id="login-form" class="space-y-6">
                    <div>
                        <h2 class="text-center text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
                        <p class="mt-2 text-center text-sm text-gray-600">
                            Or
                            <a href="#" id="show-signup" class="font-medium text-indigo-600 hover:text-indigo-500">create a new account</a>
                        </p>
                    </div>
                    <form class="mt-8 space-y-6" id="loginForm">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="login-email" class="sr-only">Email address</label>
                                <input id="login-email" name="email" type="email" required
                                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="Email address">
                            </div>
                            <div>
                                <label for="login-password" class="sr-only">Password</label>
                                <input id="login-password" name="password" type="password" required
                                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="Password">
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Signup Form -->
                <div id="signup-form" class="space-y-6 hidden">
                    <div>
                        <h2 class="text-center text-3xl font-extrabold text-gray-900">Create your account</h2>
                        <p class="mt-2 text-center text-sm text-gray-600">
                            Already have an account?
                            <a href="#" id="show-login" class="font-medium text-indigo-600 hover:text-indigo-500">sign in</a>
                        </p>
                    </div>
                    <form class="mt-8 space-y-6" id="signupForm" method="post">
                        <div class="space-y-4">
                            <div>
                                <label for="signup-Fname" class="block text-sm font-medium text-gray-700">First Name</label>
                                <input id="signup-Fname" name="Firstname" type="text" required
                                    class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="John">
                            </div>
                            <div>
                                <label for="signup-Lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input id="signup-Lname" name="Lastname" type="text" required
                                    class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Doe">
                            </div>
                            <div>
                                <label for="signup-email" class="block text-sm font-medium text-gray-700">Email address</label>
                                <input id="signup-email" name="email" type="email" required
                                    class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="email@example.com">
                            </div>
                            <div>
                                <label for="signup-password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input id="signup-password" name="password" type="password" required
                                    class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="••••••••">
                            </div>
                            <div>
                                <label for="signup-role" class="block text-sm font-medium text-gray-700">I am a</label>
                                <select id="signup-role" name="role" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select role</option>
                                    <option value="client">Client</option>
                                    <option value="livreur">Livreur (Driver)</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
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
    </script>
</body>

</html>