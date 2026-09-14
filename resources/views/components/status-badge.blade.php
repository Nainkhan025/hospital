@props(['status'])

@php
    [$bg, $dot, $label] = match($status) {
        'pending'   => ['bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300',  'bg-amber-500',  'Pending'],
        'confirmed' => ['bg-blue-100 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300',    'bg-blue-500',   'Confirmed'],
        'completed' => ['bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300', 'bg-emerald-500', 'Completed'],
        'cancelled' => ['bg-red-100 dark:bg-red-950/60 text-red-800 dark:text-red-300',      'bg-red-500',    'Cancelled'],
        'no_show'   => ['bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300',    'bg-gray-500',   'No Show'],
        'unpaid'    => ['bg-orange-100 dark:bg-orange-950/60 text-orange-800 dark:text-orange-300','bg-orange-500', 'Unpaid'],
        'paid'      => ['bg-green-100 dark:bg-green-950/60 text-green-800 dark:text-green-300',  'bg-green-500',  'Paid'],
        default     => ['bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300',    'bg-gray-400',   ucfirst($status)],
    };
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $bg }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
    {{ $label }}
</span>
