<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TraciF') }}</title>
    <link rel="icon" href="{{ asset('images/tracif-logo.png') }}"> {{-- Pastikan path favicon.png ada di public/ --}}

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full font-sans antialiased">
    <div x-data="{ open: true }" class="flex h-full overflow-hidden bg-slate-100">
        @include('layouts.partials.admin-sidebar')

        <div class="flex-1 flex flex-col overflow-y-auto">
            @include('layouts.navigation')

            <main class="flex-grow p-4 sm:p-6">
                @if (isset($header))
                    <header class="bg-white shadow rounded-lg mb-6">
                        <div class="max-w-full mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>