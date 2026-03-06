@php
    $groups = [
        // 'Platform' => [
        //     [
        //         'name' => 'Dashboard',
        //         'icon' => 'home',
        //         'url' => route('dashboard'),
        //         'current' => request()->routeIs('dashboard'),
        //     ],
        // ],
        'Management' => [
            [
                'name' => 'Tableros',
                'icon' => 'rectangle-stack',
                'url' => route('admin.boards.index'),
                'current' => request()->routeIs('admin.boards.*'),
            ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

        <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

        <x-app-logo href="{{ route('admin.boards.index') }}" wire:navigate />

        {{-- NAVBAR PRINCIPAL --}}
        <flux:navbar class="max-lg:hidden gap-6 ml-6">

            {{-- Selector de Workspaces Dinámico --}}
            <flux:dropdown position="bottom" align="start">
                <flux:button variant="ghost" icon-trailing="chevron-down">
                    <span class="font-semibold">Mis Espacios</span>
                </flux:button>

                <flux:menu class="w-56">
                    <flux:menu.group heading="Secciones">
                        {{-- Link para ver todos --}}
                        <flux:menu.item href="{{ route('admin.boards.index') }}">
                            Todos los tableros
                        </flux:menu.item>

                        {{-- Links de cada espacio --}}
                        @foreach (auth()->user()->workspaces as $ws)
                            <flux:menu.item href="{{ route('workspaces.boards.index', $ws->slug) }}">
                                {{ $ws->name }}
                            </flux:menu.item>
                        @endforeach
                    </flux:menu.group>

                    <flux:menu.separator />

                    {{-- Disparador del Modal que acabamos de crear --}}
                    <flux:modal.trigger name="create-workspace">
                        <flux:menu.item icon="plus">Nueva Sección</flux:menu.item>
                    </flux:modal.trigger>
                </flux:menu>
            </flux:dropdown>

            <flux:separator vertical class="my-2" />

            {{-- Tus links originales de Management --}}
            @foreach ($groups as $group => $links)
                @foreach ($links as $link)
                    <flux:navbar.item icon="{{ $link['icon'] }}" :href="$link['url']" :current="$link['current']"
                        wire:navigate>
                        {{ __($link['name']) }}
                    </flux:navbar.item>
                @endforeach
            @endforeach

        </flux:navbar>

        <flux:spacer />

        {{-- NAVBAR DERECHA --}}
        <flux:navbar class="me-1.5 py-0!">
            <flux:dropdown position="bottom" align="end">
                {{-- Botón con Avatar Circular y Nombre --}}
                <flux:button variant="ghost" class="flex items-center gap-2 !rounded-lg px-2">
                    <div class="size-8 overflow-hidden rounded-full border border-zinc-200 dark:border-zinc-700">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                            class="h-full w-full object-cover">
                    </div>
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-200 max-sm:hidden">
                        {{ auth()->user()->name }}
                    </span>
                    <flux:icon name="chevron-down" variant="micro" class="text-zinc-400" />
                </flux:button>

                <flux:menu class="w-64">
                    <div class="flex items-center gap-3 px-2 py-2 text-start">
                        <div class="size-10 overflow-hidden rounded-full border border-zinc-200 dark:border-zinc-700">
                            <img src="{{ auth()->user()->avatar_url }}" class="h-full w-full object-cover">
                        </div>
                        <div class="grid flex-1 text-sm leading-tight">
                            <flux:heading class="truncate font-semibold">{{ auth()->user()->name }}</flux:heading>
                            <flux:text class="truncate text-xs text-zinc-500">{{ auth()->user()->email }}</flux:text>
                        </div>
                    </div>

                    <flux:menu.separator />

                    <flux:menu.item :href="route('profile.edit')" icon="user" wire:navigate>
                        {{ __('Mi Perfil') }}
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            variant="danger" class="w-full text-start">
                            {{ __('Cerrar Sesión') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:navbar>

    </flux:header>

    {{-- MOBILE SIDEBAR --}}
    <flux:sidebar collapsible="mobile" sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('admin.boards.index') }}" wire:navigate />
            <flux:sidebar.collapse />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            @foreach ($groups as $group => $links)
                <flux:sidebar.group :heading="$group">
                    @foreach ($links as $link)
                        <flux:sidebar.item icon="{{ $link['icon'] }}" :href="$link['url']"
                            :current="$link['current']" wire:navigate>
                            {{ __($link['name']) }}
                        </flux:sidebar.item>
                    @endforeach
                </flux:sidebar.group>
            @endforeach
        </flux:sidebar.nav>

    </flux:sidebar>

    {{ $slot }}

    @fluxScripts

    <livewire:workspace-manager />
</body>

</html>
