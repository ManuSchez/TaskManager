@props([
    'sidebar' => false,
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <img 
        src="{{ asset('images/Logo.png') }}" 
        style="width: 60px !important; height: 48px !important; min-width: 48px !important;" 
        class="object-contain" 
        alt="Task_Manager Logo"
    >
    
    <span class="font-bold text-xl dark:text-white">Task_Manager</span>
</div>