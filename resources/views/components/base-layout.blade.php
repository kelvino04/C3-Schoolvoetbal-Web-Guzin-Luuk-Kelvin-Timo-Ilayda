<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schoolvoetball</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="flex flex-col min-h-screen">
    <header class="bg-blue-800 text-white text-center p-4">
        <h1 class="text-2xl">Schoolvoetball</h1>
        <p>Welkom bij de Schoolvoetball applicatie</p>
    </header>

    <main class="flex-1 p-6 text-center">
        {{ $slot }}
    </main>

    <footer class="bg-gray-900 text-white text-center p-4">
        <p>&copy; 2025 Team:</p>
        <ul class="flex justify-center gap-4 list-none p-0 m-0">
            <li>Güzin K.</li>
            <li>Ilayda Ç.</li>
            <li>Kelvin S.</li>
            <li>Luuk D.</li>
            <li>Timo V.</li>
        </ul>
    </footer>

    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
