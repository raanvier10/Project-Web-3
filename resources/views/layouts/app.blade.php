<!DOCTYPE html>
<html lang="id" id="htmlRoot">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>English For Akhwat (EFA) - Kursus Bahasa Inggris</title>
    <meta name="description" content="EFA - Program kursus bahasa Inggris khusus akhwat. Tingkatkan kemampuan bahasa Inggris Anda bersama komunitas yang supportif.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 overflow-x-hidden">
    @yield('content')
    @yield('scripts')
</body>
</html>