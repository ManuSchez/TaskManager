@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Task_Manager" {{ $attributes }}>
        <x-slot name="logo">
            <img 
                src="{{ asset('images/Logo.png') }}" 
                class="size-10 object-contain"
                alt="Task_Manager Logo"
            >
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Task_Manager" {{ $attributes }}>
        <x-slot name="logo">
            <img 
                src="{{ asset('images/Logo.png') }}" 
                class="size-10 object-contain"
                alt="Task_Manager Logo"
            >
        </x-slot>
    </flux:brand>
@endif