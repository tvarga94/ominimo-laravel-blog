@if(auth()->check())
    {{-- Authenticated Layout --}}
    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
                Ominimo Test Task Laravel Blog
            </h2>
        </x-slot>

        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                    {{-- Create New Post Button --}}
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('posts.create') }}"
                           class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600 transition">
                            ➕ Create New Post
                        </a>
                    </div>

                    @include('posts.list')

                </div>
            </div>
        </div>
    </x-app-layout>

@else
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ominimo Test Task Laravel Blog</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative min-h-screen flex flex-col items-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                {{-- Header --}}
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <h1 class="text-2xl font-semibold">Ominimo Test Task Laravel Blog</h1>
                    </div>
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-black dark:text-white">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-black dark:text-white">Register</a>
                            @endif
                        </nav>
                    @endif
                </header>

                @include('posts.list')

                {{-- Footer --}}
                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>

            </div>
        </div>
    </div>
    </body>
    </html>
@endif
