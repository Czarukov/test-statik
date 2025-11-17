<!-- resources/views/components/layout/reservation.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    </head>
    <body class="bg-stone-200 dark:bg-stone-900 dark:text-stone-100 text-stone-900 flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        {{ $slot }}
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    </body>
</html>