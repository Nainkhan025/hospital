@props(['class' => ''])

<div {{ $attributes->merge(['class' => "bg-white dark:bg-[#111827] rounded-2xl shadow-sm border border-gray-100 dark:border-[#1F2937] overflow-hidden $class"]) }}>
    @isset($header)
        <div class="px-6 py-4 border-b border-gray-100 dark:border-[#1F2937] flex items-center justify-between">
            {{ $header }}
        </div>
    @endisset

    <div class="p-6">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="px-6 py-4 border-t border-gray-100 dark:border-[#1F2937] bg-gray-50 dark:bg-[#1F2937]/50">
            {{ $footer }}
        </div>
    @endisset
</div>
