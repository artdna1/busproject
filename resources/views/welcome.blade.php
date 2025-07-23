<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quantum Sky Bus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-100 to-blue-200 min-h-screen flex flex-col justify-between">

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-800">Quantum Sky Bus</h1>
            <div class="space-x-4">
                <a href="#features" class="text-gray-600 hover:text-blue-700">Features</a>
                <a href="#about" class="text-gray-600 hover:text-blue-700">About</a>
                <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="flex-grow flex items-center justify-center text-center px-6">
        <div class="max-w-3xl">
            <h2 class="text-4xl md:text-5xl font-extrabold text-blue-800 mb-4">Seamless Bus Booking, Anytime</h2>
            <p class="text-lg text-gray-700 mb-6">
                Welcome to <strong>Quantum Sky Bus</strong> — your trusted partner for fast, reliable, and hassle-free bus ticket reservations.
            </p>
            <a href="/register" class="bg-blue-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-700 transition">
                Book Your Trip Now
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="bg-white py-16 px-6">
        <div class="max-w-6xl mx-auto text-center">
            <h3 class="text-3xl font-bold text-blue-800 mb-10">Features</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-blue-50 p-6 rounded shadow">
                    <h4 class="text-xl font-semibold text-blue-700 mb-2">Easy Booking</h4>
                    <p class="text-gray-600">Reserve your seat with just a few clicks. Fast and user-friendly.</p>
                </div>
                <div class="bg-blue-50 p-6 rounded shadow">
                    <h4 class="text-xl font-semibold text-blue-700 mb-2">Real-time Schedules</h4>
                    <p class="text-gray-600">Always up-to-date with the latest available trips and schedules.</p>
                </div>
                <div class="bg-blue-50 p-6 rounded shadow">
                    <h4 class="text-xl font-semibold text-blue-700 mb-2">Secure Payments</h4>
                    <p class="text-gray-600">Your payment and booking data are encrypted and secure.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 px-6 bg-blue-100">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="text-3xl font-bold text-blue-800 mb-4">About Quantum Sky Bus</h3>
            <p class="text-gray-700 text-lg">
                Quantum Sky Bus is a modern ticket reservation system built to streamline the way you travel. Whether you're commuting daily or planning a long trip, we ensure a reliable and efficient booking experience.
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t py-6">
        <div class="max-w-7xl mx-auto text-center text-gray-600">
            &copy; 2025 Quantum Sky Bus. All rights reserved.
        </div>
    </footer>

</body>

</html>