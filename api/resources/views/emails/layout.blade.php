<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    {{--PageDone - Tailwind CSS--}}
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />

    <title>@yield('mail_title')</title>
</head>
<body class="bg-gray-50 text-gray-900">

<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-semibold text-indigo-600">@yield('mail_title')</h1>
    </div>

    @yield('mail_content')

    <!-- Footer -->
    <div class="mt-6 text-center text-sm text-gray-500">
        <p>Якщо ви не запитували скидання пароля, проігноруйте цей лист.</p>
        <p>© {{ date('Y') }} Ваша компанія. Усі права захищені.</p>
    </div>
</div>

{{--PageDone - Tailwind CSS--}}
<script src="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/js/pagedone.js"></script>
</body>
</html>
