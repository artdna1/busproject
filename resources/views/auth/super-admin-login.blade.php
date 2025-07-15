<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Super Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded shadow w-96">
        <h2 class="text-xl font-bold mb-4">Quantum Sky Super Admin Login</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('super-admin.login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold">Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded font-semibold">
                Login
            </button>
        </form>
    </div>
</body>
</html>
