@props(['type' => 'success', 'message'])

@php
    $styles = match($type) {
        'success' => 'bg-emerald-50 dark:bg-emerald-950/40 border-emerald-400 text-emerald-800 dark:text-emerald-300',
        'error'   => 'bg-red-50 dark:bg-red-950/40 border-red-400 text-red-800 dark:text-red-300',
        'warning' => 'bg-amber-50 dark:bg-amber-950/40 border-amber-400 text-amber-800 dark:text-amber-300',
        'info'    => 'bg-blue-50 dark:bg-blue-950/40 border-blue-400 text-blue-800 dark:text-blue-300',
        default   => 'bg-gray-50 dark:bg-gray-900 border-gray-400 text-gray-800 dark:text-gray-200',
    };
    $icons = match($type) {
        'success' => '✓',
        'error'   => '✕',
        'warning' => '⚠',
        'info'    => 'ℹ',
        default   => '•',
    };
@endphp

<div {{ $attributes->merge(['class' => "border-l-4 p-4 rounded-r-lg flex items-start gap-3 $styles"]) }}
     x-data="{ show: true }"
     x-show="show"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <span class="font-bold text-lg leading-none mt-0.5">{{ $icons }}</span>
    <p class="flex-1 text-sm font-medium">{{ $message }}</p>
    <button @click="show = false" class="opacity-60 hover:opacity-100 transition-opacity ml-2 text-lg leading-none">&times;</button>
</div>
