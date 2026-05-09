<!DOCTYPE html>
<html lang="uk" class="scroll-smooth">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="description" content="Сучасний інтернет-магазин електроніки. Найкращі ціни, швидка доставка по Україні." />

        <title>TechStore — Електроніка нового покоління</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Remix Icons --}}
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"
            rel="stylesheet"
            crossorigin="anonymous"
        />

        @inertiaHead
        @routes
    </head>
    <body class="min-h-screen bg-surface-50">
        @inertia
    </body>
</html>
