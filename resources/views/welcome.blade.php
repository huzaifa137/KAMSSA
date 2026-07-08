<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen flex items-center justify-center px-4">
    <div class="w-full bg-white shadow-xl rounded-none p-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">🚀 Welcome Mr. Yiga Ahmed</h1>
        <p class="text-lg text-gray-600 mb-6">
            This application is running locally on Huzaiphar's home server 😁😁😁🤳
        </p>

        <div class="text-sm text-gray-400">
            Lets go get those 2 Millions from sozo In sha Allah 😎🤞✌ and Laravel {{ Illuminate\Foundation\Application::VERSION }}
        </div>
    </div>

</body>

</html>