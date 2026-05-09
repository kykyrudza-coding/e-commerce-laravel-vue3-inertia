@extends('emails.layout')

@section('mail_title')
    Скидання паролю
@endsection

@section('mail_content')
    <p class="text-lg mb-4">Привіт, {{ $name }}!</p>
    <p class="mb-4">Щоб скинути пароль, натисніть на кнопку нижче:</p>

    <div class="text-center">
        <a href="{{ $resetLink }}" class="inline-block bg-indigo-600 text-white text-lg font-semibold py-3 px-6 rounded-full shadow-lg hover:bg-indigo-700 transition duration-300">
            Скинути пароль
        </a>
    </div>

    <p class="mt-4">Якщо ви не запитували скидання пароля, просто проігноруйте цей лист.</p>
@endsection
