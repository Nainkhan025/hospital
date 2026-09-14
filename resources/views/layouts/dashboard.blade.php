<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} | MedCare Hospital</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

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
<body class="font-sans antialiased h-full bg-gray-50 dark:bg-[#090D16] dark:text-[#F9FAFB] transition-colors duration-200">

<div class="min-h-screen flex bg-gray-50 dark:bg-[#090D16]">
    <!-- Sidebar: Full height, sticky from top-0 -->
    <x-dashboard.sidebar />

    <!-- Main Content Area (Right Column) -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        <!-- Top Nav -->
        <x-dashboard.topbar />

        <!-- Page Header -->
        @isset($header)
            <div class="bg-white dark:bg-[#111827] border-b border-gray-200 dark:border-[#1F2937] h-16 flex items-center px-6">
                <div class="flex items-center justify-between w-full">
                    {{ $header }}
                </div>
            </div>
        @endisset

        <!-- Flash Messages -->
        @if(session('success'))
            <x-alert type="success" :message="session('success')" class="mx-6 mt-4" />
        @endif
        @if(session('error'))
            <x-alert type="error" :message="session('error')" class="mx-6 mt-4" />
        @endif

        <!-- Content -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
</div>

@livewireScripts
</body>
</html>
