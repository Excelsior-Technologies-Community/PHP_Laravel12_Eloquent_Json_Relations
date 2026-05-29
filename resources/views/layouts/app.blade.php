<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen">

    <main class="max-w-6xl mx-auto py-10 px-4">
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>