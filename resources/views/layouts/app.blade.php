<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }} — MedCare</title>
    <meta name="description" content="{{ $description ?? 'MedCare Hospital — Specialist care, every day.' }}">

    <!-- Fonts: Geist + Instrument Serif -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="antialiased bg-[var(--canvas)] text-[var(--ink)] transition-colors duration-200">

    <x-public.navbar />

    @if(session('success'))
        <div class="max-w-5xl mx-auto px-4 pt-4">
            <x-alert type="success" :message="session('success')" />
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-5xl mx-auto px-4 pt-4">
            <x-alert type="error" :message="session('error')" />
        </div>
    @endif

    <main>{{ $slot }}</main>

    <x-public.footer />

    <!-- Scroll reveal observer -->
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(el => {
                if (el.isIntersecting) {
                    el.target.classList.add('in-view');
                    observer.unobserve(el.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>

    @livewireScripts
</body>
</html>
